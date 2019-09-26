<?php

namespace JoyBusinessAcademy\Profile\Models;

use Illuminate\Database\Eloquent\Model;
use JoyBusinessAcademy\Profile\ProfileServiceProvider;
use JoyBusinessAcademy\Profile\Contracts\Profile AS ProfileContract;
use JoyBusinessAcademy\Profile\Traits\BelongsToRegion;
use JoyBusinessAcademy\Profile\Traits\BelongsToUser;
use JoyBusinessAcademy\Profile\Traits\RefreshesProfileCache;


class Profile extends Model implements ProfileContract
{
    use BelongsToUser, BelongsToRegion, RefreshesProfileCache;

    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';
    const GENDER_OTHER = 'other';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'gender',
        'avatar',
        'location',
        'region_id',
        'date_of_birth',
        'ethnicity',
        'residency',
        'employment_status',
    ];

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('jba-profile.table_names.profiles'));
    }

    public static function boot()
    {
        parent::boot();
    }

    public static function create(array $attributes = [])
    {
        if(ProfileServiceProvider::isNotLumen() && app()->version() < '5.4') {
            return parent::create($attributes);
        }

        return static::query()->create($attributes);
    }

    public function scopeWithAll($query)
    {
        $query->with(['region']);
    }
}
