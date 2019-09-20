<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 8/21/2019
 * Time: 4:13 PM
 */

namespace JoyBusinessAcademy\Profile\Models;


use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'parent_id'
    ];

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('jba-profile.table_names.regions'));
    }

    public static function boot()
    {
        parent::boot();
    }

    public function parent()
    {
        return $this->belongsTo(config('jba-profile.models.region'), 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(config('jba-profile.models.region'), 'parent_id');
    }
}