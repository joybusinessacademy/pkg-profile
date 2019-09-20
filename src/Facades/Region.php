<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 9/18/2019
 * Time: 4:32 PM
 */

namespace JoyBusinessAcademy\Profile\Facades;


use Illuminate\Support\Facades\Facade;

class Region extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'JBAProfileRegion';
    }
}