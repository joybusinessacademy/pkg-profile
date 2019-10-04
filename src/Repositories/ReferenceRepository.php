<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 10/4/2019
 * Time: 9:18 AM
 */

namespace JoyBusinessAcademy\Profile\Repositories;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use JoyBusinessAcademy\Profile\Exceptions\ProfileException;
use JoyBusinessAcademy\Profile\ProfileGateway;

class ReferenceRepository extends BaseRepository
{
    public function __construct(ProfileGateway $gateway)
    {
        $model = config('jba-profile.models.reference');

        parent::__construct($gateway, new $model());
    }

    public function addOneProfileReference(Model $user, $reference)
    {
        if(!$reference instanceof Model) {

            $reference = $this->model->fill($reference);
        }

        return $this->addProfileReferences($user, collect([$reference]));
    }

    public function deleteOneProfileReference(Model $user, $reference)
    {
        if($reference instanceof Model) {
            $id = $reference->id;
        }
        else if(is_int($reference)) {
            $id = $reference;
        }
        else if(ctype_digit($reference)) {
            $id = (int) $reference;
        }
        else {
            throw new ProfileException('Invalid data to delete a reference');
        }

        $this->deleteProfileReferences($user, [$id]);

        return true;
    }

    public function addProfileReferences(Model $user, $references)
    {
        if(!$profile = $this->gateway->getUserProfile($user)) {

            throw new ProfileException('Unable to add reference as user profile does not exist');
        }

        if(!$references instanceof Collection) {

            $referenceClass = config('jba-profile.models.reference');

            foreach($references as &$item) {
                if(!$item instanceof Model) {
                    $item = new $referenceClass($item);
                }
            }
        }

        $profile->references()->saveMany($references);

        return true;
    }

    public function deleteProfileReferences(Model $user, array $referenceIds)
    {
        if($profile = $this->gateway->getUserProfile($user)) {

            $references = $profile->references()->whereIn('id', $referenceIds);

            $references->each(function($e){
                $e->delete();
            });
        }

        return true;
    }

    public function updateOneProfileReference(Model $user, $data)
    {
        if($profile = $this->gateway->getUserProfile($user)) {

            if($reference = $profile->references()->where('id', $data['id'])->first()) {

                $reference->update($data);
            }
        }

        return true;
    }
}