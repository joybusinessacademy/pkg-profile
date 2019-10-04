<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 9/23/2019
 * Time: 10:09 AM
 */

namespace JoyBusinessAcademy\Profile\Contracts;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


interface Profile
{

    /**
     * A profile may belong to a user
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo;

    /**
     * A profile may belong to a region
     * @return BelongsTo
     */
    public function region(): BelongsTo;

    /**
     * A profile may have multiple experiences
     */
    public function experiences(): HasMany;
}