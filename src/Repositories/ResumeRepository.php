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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
        $profile = $this->gateway->getUserProfile($user);

        if(!$path) {
            $reflector = new \ReflectionClass($this->model);
            $prefix = $reflector->getConstant('RESUME_PATH');
            $path = (config('app.env') ? config('app.env') : config('env')) .  '/' . trim($prefix, '/') . '/';
        }

        $filePath = $path . Str::uuid()->toString();

        $this->deleteProfileResume($user);

        Storage::disk('s3')->put($filePath, file_get_contents($file));

        $profile->resume()->create([
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'file_type' => $file->getClientMimeType(),
            'file_path' => $filePath
        ]);

        return $profile->resume()->first();
    }

    public function deleteProfileResume(Model $user)
    {
        $profile = $this->gateway->getUserProfile($user);

        if($profile->resume) {
            Storage::disk('s3')->delete($profile->resume->file_path);
            $profile->resume->delete();
        }

        return true;
    }
}