<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 10/3/2019
 * Time: 12:50 PM
 */

namespace JoyBusinessAcademy\Profile\Models;


use Illuminate\Database\Eloquent\Model;
use JoyBusinessAcademy\Profile\Traits\RefreshesProfileCache;

class Education extends Model
{
    use RefreshesProfileCache;

    protected $fillable = [
        'profile_id',
        'school',
        'degree',
        'major',
        'description',
        'start_year',
        'end_year',
        'grade',
        'activities_and_societies',
    ];

    public $timestamps = false;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('jba-profile.table_names.educations'));
    }

    public function profile()
    {
        return $this->belongsTo(config('jba-profile.models.profile'), 'profile_id');
    }
}