<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 10/5/2019
 * Time: 9:38 PM
 */

namespace JoyBusinessAcademy\Profile\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use JoyBusinessAcademy\Profile\Exceptions\ProfileException;
use JoyBusinessAcademy\Profile\Models\Resume;
use JoyBusinessAcademy\Profile\ProfileGateway;

class ResumeRepository extends BaseRepository
{
    public function __construct(ProfileGateway $gateway)
    {
        $model = config('jba-profile.models.resume');

        parent::__construct($gateway, new $model());
    }

    public function uploadProfileResume(Model $user, UploadedFile $file, $path = null)
    {
        if(!$path) {
            $reflector = new \ReflectionClass($this->model);
            $prefix = $reflector->getConstant('RESUME_PATH');
            $path = (config('app.env') ? config('app.env') : config('env')) .  '/' . trim($prefix, '/') . '/';
        }
        if(method_exists(Str::class, "uuid")) {
            $filePath = $path . Str::uuid()->toString();
        }
        else {
            $filePath = $path . uuid();
        }

        $this->deleteProfileResume($user);

        Storage::disk('s3')->put($filePath, file_get_contents($file));

        $profile = $this->gateway->getUserProfile($user);

        $data = [
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'file_type' => $file->getClientMimeType(),
            'file_path' => $filePath
        ];

        if(config('jba-profile.attributes.resume.multiple')) {

            $resume = new Resume($data);

            return $this->addProfileResumes($user, collect([$resume]));
        }
        else {

            $profile->resume()->create($data);

            return $profile->resume()->first();
        }
    }

    public function deleteProfileResume(Model $user, Resume $resume = null)
    {
        if(!$profile = $this->gateway->getUserProfile($user)) {
            return true;
        }

        if($resume instanceof Resume) {

            $exist = $profile->resumes->contains(function($k, $e) use ($resume){
                return $e->id === $resume->id;
            });

            if($exist) {
                Storage::disk('s3')->delete($resume->file_path);
                $resume->delete();
            }
        }
        else if(!config('jba-profile.attributes.resume.multiple')) {

            //Don't delete the existing one if multiple resumes are enabled

            if ($profile->resume) {
                Storage::disk('s3')->delete($profile->resume->file_path);
                $profile->resume->delete();
            }
        }

        return true;
    }

    public function setDefaultProfileResume(Model $user, Resume $resume)
    {
        if($resume->selected) {
            return true;
        }

        if(!$profile = $this->gateway->getUserProfile($user)) {
            return true;
        }

        $exist = $profile->resumes->contains(function($k, $e) use ($resume){
            return $e->id === $resume->id;
        });

        if($exist) {

            if($default = $profile->resumes->where('selected', 1)->first()) {
                $default->update(['selected' => false]);
            }

            $resume->update(['selected' => true]);
        }

        return $resume;
    }

    public function addOneProfileResume(Model $user, UploadedFile $file, $path = null)
    {
        if(!$path) {
            $reflector = new \ReflectionClass($this->model);
            $prefix = $reflector->getConstant('RESUME_PATH');
            $path = (config('app.env') ? config('app.env') : config('env')) .  '/' . trim($prefix, '/') . '/';
        }

        $filePath = $path . Str::uuid()->toString();

        Storage::disk('s3')->put($filePath, file_get_contents($file));

        $resume = new Resume([
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'file_type' => $file->getClientMimeType(),
            'file_path' => $filePath
        ]);

        return $this->addProfileResumes($user, collect([$resume]));
    }

    public function addProfileResumes(Model $user, Collection $resumes)
    {
        if(!$profile = $this->gateway->getUserProfile($user)) {

            throw new ProfileException('Unable to add resumes as user profile does not exist');
        }

        if(!$resumes instanceof Collection) {

            $resumeClass = config('jba-profile.models.resume');

            foreach($resumes as &$item) {
                if(!$item instanceof Model) {
                    $item = new $resumeClass($item);
                }
            }
        }

        $profile->resumes()->saveMany($resumes);

        return true;
    }

    public function getResumeContent(Resume $resume)
    {
        return Storage::disk('s3')->get($resume->file_path);
    }
}