<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 10/7/2019
 * Time: 10:31 AM
 */

namespace JoyBusinessAcademy\Profile\Traits;


use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasOneResume
{
    public function resume(): HasOne
    {
        return $this->hasOne(config('jba-profile.models.resume'), 'profile_id');
    }
}