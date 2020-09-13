<?php

namespace JoyBusinessAcademy\Profile\Models;

use Illuminate\Database\Eloquent\Model;
use JoyBusinessAcademy\Profile\ProfileServiceProvider;
use JoyBusinessAcademy\Profile\Contracts\Profile AS ProfileContract;
use JoyBusinessAcademy\Profile\Traits\BelongsToRegion;
use JoyBusinessAcademy\Profile\Traits\BelongsToUser;
use JoyBusinessAcademy\Profile\Traits\HasManyEducations;
use JoyBusinessAcademy\Profile\Traits\HasManyExperiences;
use JoyBusinessAcademy\Profile\Traits\HasManyReferences;
use JoyBusinessAcademy\Profile\Traits\HasManyResumes;
use JoyBusinessAcademy\Profile\Traits\HasManySkills;
use JoyBusinessAcademy\Profile\Traits\HasOneResume;
use JoyBusinessAcademy\Profile\Traits\RefreshesProfileCache;


class Profile extends Model implements ProfileContract
{
    use BelongsToUser,
        BelongsToRegion,
        HasManyExperiences,
        HasManyEducations,
        HasManyReferences,
        HasOneResume,
        HasManyResumes,
        HasManySkills,
        RefreshesProfileCache;

    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';
    const GENDER_OTHER = 'other';

    const EMPLOYMENT_YES = 1;
    const EMPLOYMENT_NOT = 2;
    const EMPLOYMENT_NO_INTEREST = 4;
    const EMPLOYMENT_OTHER = 8;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'gender',
        'avatar',
        'personal_summary',
        'cover_letter',
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

    public static function getGenderConstants()
    {
        $reflector = new \ReflectionClass(self::class);
        $constants = $reflector->getConstants();

        $genders = [];

        foreach($constants as $name => $value) {
            if(strpos($name, 'GENDER_') === 0) {
                $genders[] = $value;
            }
        }

        return $genders;
    }

    public static function getEmploymentConstants()
    {

        $reflector = new \ReflectionClass(self::class);
        $constants = $reflector->getConstants();

        $employments = [];

        foreach($constants as $name => $value) {
            if(strpos($name, 'EMPLOYMENT_') === 0) {
                $employments[] = $value;
            }
        }

        return $employments;
    }
}
