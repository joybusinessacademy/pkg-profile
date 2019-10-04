<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 10/3/2019
 * Time: 1:02 PM
 */

namespace JoyBusinessAcademy\Profile\Traits;


use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManyEducations
{
    public function educations(): HasMany
    {
        return $this->hasMany(config('jba-profile.models.education'), 'profile_id', 'id');
    }
}