<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 10/4/2019
 * Time: 9:24 AM
 */

namespace JoyBusinessAcademy\Profile\Repositories;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use JoyBusinessAcademy\Profile\Exceptions\ProfileException;
use JoyBusinessAcademy\Profile\ProfileGateway;

class EducationRepository extends BaseRepository
{

    public function __construct(ProfileGateway $gateway)
    {
        $model = config('jba-profile.models.education');

        parent::__construct($gateway, new $model());
    }

    public function addOneProfileEducation(Model $user, $education)
    {
        if(!$education instanceof Model) {
            $education = $this->model->fill($education);
        }

        return $this->addProfileEducations($user, collect([$education]));

    }

    public function addProfileEducations(Model $user, $educations)
    {
        if(!$profile = $this->gateway->getUserProfile($user)) {

            throw new ProfileException('Unable to add eduction as user profile does not exist');
        }

        if(!$educations instanceof Collection) {

            $educationClass = config('jba-profile.models.education');

            foreach($educations as &$item) {
                if(!$item instanceof Model) {
                    $item = new $educationClass($item);
                }
            }
        }

        $profile->educations()->saveMany($educations);

        return true;
    }

    public function updateOneProfileEducation(Model $user, $data)
    {
        if($profile = $this->gateway->getUserProfile($user)) {

            if(!$education = $profile->educations->where('id', $data['id'])->first()) {

                throw new ProfileException('Unable to update a education that does not exist');

            }

            $education->update($data);
        }

        return true;
    }

    public function deleteOneProfileEducation(Model $user, Model $education)
    {
        if($education instanceof Model) {
            $id = $education->id;
        }
        else if(is_int($education)) {
            $id = $education;
        }
        else if(ctype_digit($education)) {
            $id = (int) $education;
        }
        else {
            throw new ProfileException('Invalid data to delete an education');
        }

        $this->deleteProfileEducations($user, [$id]);

        return true;
    }

    public function deleteProfileEducations(Model $user, array $educationIds)
    {
        if($profile = $this->gateway->getUserProfile($user)) {

            $educations = $profile->educations()->whereIn('id', $educationIds);

            $educations->each(function($e){
                $e->delete();
            });
        }

        return true;
    }
}