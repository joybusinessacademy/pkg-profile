<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 10/3/2019
 * Time: 7:53 AM
 */

namespace JoyBusinessAcademy\Profile\Models;


use Illuminate\Database\Eloquent\Model;
use JoyBusinessAcademy\Profile\Traits\BelongsToProfile;
use JoyBusinessAcademy\Profile\Traits\RefreshesProfileCache;

class Experience extends Model
{
    use RefreshesProfileCache, BelongsToProfile;

    const TYPE_FULL_TIME = 1;
    const TYPE_PART_TIME = 2;
    const TYPE_CONTRACT = 3;
    const TYPE_CASUAL = 4;
    const TYPE_FREELANCE = 5;
    const TYPE_SELF_EMPLOYED = 6;
    const TYPE_INTERNSHIP = 7;
    const TYPE_APPRENTICESHIP = 8;

    protected $fillable = [
        'profile_id',
        'title',
        'type',
        'company',
        'headline',
        'description',
        'location',
        'current_employment',
        'start_date',
        'end_date',
        'industry'
    ];

    public $timestamps = false;

    protected $dates = ['start_date', 'end_date'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('jba-profile.table_names.experiences'));
    }

    public static function getTypeConstants()
    {
        $reflector = new \ReflectionClass(self::class);
        $constants = $reflector->getConstants();

        $types = [];

        foreach($constants as $name => $value) {
            if(strpos($name, 'TYPE_') === 0) {
                $types[] = $value;
            }
        }

        return $types;
    }

    public function getCurrentEmploymentAttribute($current)
    {
        return (boolean) $current;
    }
}