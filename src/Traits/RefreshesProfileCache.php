<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 9/23/2019
 * Time: 4:25 PM
 */

namespace JoyBusinessAcademy\Profile\Traits;


use Illuminate\Database\Eloquent\Model;

trait RefreshesProfileCache
{
    public static function bootRefreshesProfileCache()
    {
        static::saved(function() {
            app('JBAProfileGateway')->forgetCachedProfile();
        });

        static::updated(function() {
            app('JBAProfileGateway')->forgetCachedProfile();
        });

        static::deleted(function(Model $model) {

            app('JBAProfileGateway')->forgetCachedProfile();
        });
    }
}