<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 9/5/2019
 * Time: 8:06 AM
 */

namespace JoyBusinessAcademy\Profile\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use JoyBusinessAcademy\Profile\Traits\HasProfile;

class User extends Authenticatable
{
    use Notifiable, HasProfile;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('jba-profile.table_names.users'));
    }
}