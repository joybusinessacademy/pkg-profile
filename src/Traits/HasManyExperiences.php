<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 10/3/2019
 * Time: 7:59 AM
 */

namespace JoyBusinessAcademy\Profile\Traits;


use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManyExperiences
{
    public function experiences(): HasMany
    {
        return $this->hasMany(config('jba-profile.models.experience'), 'profile_id', 'id');
    }
}