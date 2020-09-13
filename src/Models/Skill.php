<?php


namespace JoyBusinessAcademy\Profile\Models;

use Illuminate\Database\Eloquent\Model;
use JoyBusinessAcademy\Profile\Traits\BelongsToProfile;
use JoyBusinessAcademy\Profile\Traits\RefreshesProfileCache;

class Skill extends Model
{
    use RefreshesProfileCache, BelongsToProfile;

    protected $fillable = [
        'profile_id',
        'skill_id',
        'name',
        'is_validated'
    ];

    public $timestamps = false;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('jba-profile.table_names.skills'));
    }
}