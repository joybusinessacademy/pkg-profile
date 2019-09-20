<?php

namespace JoyBusinessAcademy\Profile\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';
    const GENDER_OTHER = 'other';

    protected $fillable = [
        'user_id',
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

    public function user()
    {
        return $this->belongsTo(config('jba-profile.models.user'), 'user_id');
    }

    public function region()
    {
        return $this->belongsTo(config('jba-profile.models.region'), 'region_id');
    }
}
