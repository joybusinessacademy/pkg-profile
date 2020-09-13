<?php


namespace JoyBusinessAcademy\Profile\Repositories;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use JoyBusinessAcademy\Profile\Exceptions\ProfileException;
use JoyBusinessAcademy\Profile\ProfileGateway;

class SkillRepository extends BaseRepository
{
    public function __construct(ProfileGateway $gateway)
    {
        $model = config('jba-profile.models.skill');

        parent::__construct($gateway, new $model());
    }

    public function addOneProfileSkill(Model $user, $skill)
    {
        if(!$skill instanceof Model) {
            $model = config('jba-profile.models.skill');
            $skill = new $model($skill);
        }

        return $this->addProfileSkills($user, collect([$skill]));
    }

    public function addProfileSkills(Model $user, $skills)
    {
        if(!$profile = $this->gateway->getUserProfile($user)) {

            throw new ProfileException('Unable to add skill as user profile does not exist');
        }

        if(!$skills instanceof Collection) {

            $skillClass = config('jba-profile.models.skill');

            foreach($skills as &$item) {
                if(!$item instanceof Model) {
                    $item = new $skillClass($item);
                }
            }
        }

        $profile->skills()->saveMany($skills);

        return true;
    }

    public function updateOneProfileSkill(Model $user, $data)
    {
        if($profile = $this->gateway->getUserProfile($user)) {

            if(!$skill = $profile->skills->where('id', $data['id'])->first()) {

                throw new ProfileException('Unable to update a skill that does not exist');

            }

            $skill->update($data);
        }

        return true;
    }

    public function deleteOneProfileSkill(Model $user, $skill)
    {
        if($skill instanceof Model) {
            $id = $skill->id;
        }
        else if(is_int($skill)) {
            $id = $skill;
        }
        else if(ctype_digit($skill)) {
            $id = (int) $skill;
        }
        else {
            throw new ProfileException('Invalid data to delete an skill');
        }

        $this->deleteProfileSkills($user, [$id]);

        return true;
    }

    public function deleteProfileSkills(Model $user, array $skillIds = null)
    {
        if($profile = $this->gateway->getUserProfile($user)) {

            if($skillIds === null) {
                $profile->skills->each(function($e){
                    $e->delete();
                });
            }
            else {
                $profile->skills->whereIn('id', $skillIds)->each(function($e){
                    $e->delete();
                });
            }
        }

        return true;
    }

    public function cleanProfileSkills(Model $user)
    {
        return $this->deleteProfileSkills($user);
    }
}