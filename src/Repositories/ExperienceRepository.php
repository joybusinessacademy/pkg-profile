<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 10/4/2019
 * Time: 9:52 AM
 */

namespace JoyBusinessAcademy\Profile\Repositories;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use JoyBusinessAcademy\Profile\Exceptions\ProfileException;
use JoyBusinessAcademy\Profile\ProfileGateway;

class ExperienceRepository extends BaseRepository
{
    public function __construct(ProfileGateway $gateway)
    {
        $model = config('jba-profile.models.experience');

        parent::__construct($gateway, new $model());
    }

    public function addOneProfileExperience(Model $user, $experience)
    {
        if(!$experience instanceof Model) {

            $experienceClass = config('jba-profile.models.experience');
            $experience = new $experienceClass($experience);
        }

        return $this->addProfileExperiences($user, collect([$experience]));
    }

    public function deleteOneProfileExperience(Model $user, $experience)
    {
        if($experience instanceof Model) {
            $id = $experience->id;
        }
        else if(is_int($experience)) {
            $id = $experience;
        }
        else if(ctype_digit($experience)) {
            $id = (int) $experience;
        }
        else {
            throw new ProfileException('Invalid data to delete an experience');
        }

        $this->deleteProfileExperiences($user, [$id]);

        return true;
    }

    public function addProfileExperiences(Model $user, $experiences)
    {
        if(!$profile = $this->gateway->getUserProfile($user)) {

            throw new ProfileException('Unable to add experience as user profile does not exist');
        }

        if(!$experiences instanceof Collection) {

            $experienceClass = config('jba-profile.models.experience');

            foreach($experiences as &$item) {
                if(!$item instanceof Model) {
                    $item = new $experienceClass($item);
                }
            }
        }

        $profile->experiences()->saveMany($experiences);

        return true;
    }

    public function deleteProfileExperiences(Model $user, array $experienceIds)
    {
        if($profile = $this->gateway->getUserProfile($user)) {

            $experiences = $profile->experiences()->whereIn('id', $experienceIds);

            $experiences->each(function($e){
                $e->delete();
            });
        }

        return true;
    }

    public function updateOneProfileExperience(Model $user, $data)
    {
        if($profile = $this->gateway->getUserProfile($user)) {

            if($experience = $profile->experiences()->where('id', $data['id'])->first()) {

                $experience->update($data);
            }
        }

        return true;
    }
}