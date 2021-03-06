<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 8/14/2019
 * Time: 3:36 PM
 */

namespace JoyBusinessAcademy\Profile\Repositories;


use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use JoyBusinessAcademy\Profile\Events\ProfileUpdated;
use JoyBusinessAcademy\Profile\Exceptions\ProfileException;
use JoyBusinessAcademy\Profile\ProfileGateway;

class ProfileRepository extends BaseRepository
{
    protected $request;

    public function __construct(ProfileGateway $gateway)
    {
        $model = config('jba-profile.models.profile');

        parent::__construct($gateway, new $model());
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function setRequest(FormRequest $request)
    {
        $this->request = $request;

        return $this;
    }

    public function getUserProfile($userId)
    {
        return $this->model->with(['region'])->where(['user_id' => $userId])->first();
    }

    public function saveUserProfile(Model $user, array $data)
    {
        if(!$profile = $this->gateway->getUserProfile($user)) {

            $user->profile()->save($data);
        }
        else {
            $profile->update($data);

        }

        return true;
    }


}