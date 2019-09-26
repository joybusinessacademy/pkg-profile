<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 9/23/2019
 * Time: 10:33 AM
 */

namespace JoyBusinessAcademy\Profile\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToRegion
{
    public function region(): BelongsTo
    {
        return $this->belongsTo(config('jba-profile.models.region'), 'region_id');
    }
}