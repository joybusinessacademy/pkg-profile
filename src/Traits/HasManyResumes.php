<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 7/27/2020
 * Time: 1:45 PM
 */

namespace JoyBusinessAcademy\Profile\Traits;


use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManyResumes
{
    public function resumes(): HasMany
    {
        return $this->hasMany(config('jba-profile.models.resume'), 'profile_id', 'id');
    }
}