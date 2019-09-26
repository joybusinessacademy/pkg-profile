<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 9/5/2019
 * Time: 3:18 PM
 */

namespace JoyBusinessAcademy\Profile\Traits;


use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasProfile
{
    public function profile(): HasOne
    {
        return $this->hasOne(config('jba-profile.models.profile'), 'user_id', 'id');
    }
}