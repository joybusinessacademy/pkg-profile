<?php


namespace JoyBusinessAcademy\Profile\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManySkills
{
    public function skills(): HasMany
    {
        return $this->hasMany(config('jba-profile.models.skill'), 'profile_id', 'id');
    }
}