<?php


namespace JoyBusinessAcademy\Profile\Abstracts;


use Illuminate\Database\Eloquent\Model;
use JoyBusinessAcademy\Profile\Contracts\Profile;

abstract class ProfileEventAbstract
{
    public $profile;

    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
    }
}