<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 9/18/2019
 * Time: 4:17 PM
 */

namespace JoyBusinessAcademy\Profile\Facades;


use Illuminate\Support\Facades\Facade;

class Profile extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'JBAProfileGateway';
    }
}