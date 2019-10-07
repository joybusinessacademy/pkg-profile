<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 10/5/2019
 * Time: 8:43 PM
 */

namespace JoyBusinessAcademy\Profile\Traits;


use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToProfile
{
    public function profile(): BelongsTo
    {
        return $this->belongsTo(config('jba-profile.models.profile'), 'profile_id');
    }
}