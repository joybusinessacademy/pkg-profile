<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 10/3/2019
 * Time: 3:23 PM
 */

namespace JoyBusinessAcademy\Profile\Models;


use Illuminate\Database\Eloquent\Model;
use JoyBusinessAcademy\Profile\Traits\RefreshesProfileCache;

class Reference extends Model
{
    use RefreshesProfileCache;

    protected $fillable = [
        'profile_id',
        'referrer',
        'company',
        'job_title',
        'phone',
        'email',
        'description'
    ];

    public $timestamps = false;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('jba-profile.table_names.references'));
    }

    public function profile()
    {
        return $this->belongsTo(config('jba-profile.models.profile'), 'profile_id');
    }
}