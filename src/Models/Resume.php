<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 10/5/2019
 * Time: 8:37 PM
 */

namespace JoyBusinessAcademy\Profile\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use JoyBusinessAcademy\Profile\Traits\BelongsToProfile;
use JoyBusinessAcademy\Profile\Traits\RefreshesProfileCache;

class Resume extends Model
{
    use RefreshesProfileCache, BelongsToProfile;

    const RESUME_PATH = 'profile/resume';

    protected $fillable = [
        'id',
        'profile_id',
        'file_name',
        'file_type',
        'file_size',
        'file_path'
    ];

    public $appends = ['url', 'size_in_kb'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('jba-profile.table_names.resumes'));
    }

    public function getUrlAttribute()
    {
        return Storage::disk('s3')->url($this->file_path);
    }

    public function getSizeInKbAttribute()
    {
        return round($this->file_size / 1024, 2);
    }
}