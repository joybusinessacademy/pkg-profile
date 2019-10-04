<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 10/3/2019
 * Time: 3:26 PM
 */

namespace JoyBusinessAcademy\Profile\Traits;


use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManyReferences
{
    public function references(): HasMany
    {
        return $this->hasMany(config('jba-profile.models.reference'), 'profile_id', 'id');
    }
}