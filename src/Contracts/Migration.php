<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 7/30/2020
 * Time: 8:15 AM
 */

namespace JoyBusinessAcademy\Profile\Contracts;

use Illuminate\Database\Migrations\Migration AS Base;

abstract class Migration extends Base
{
    protected function getTableName($table)
    {
        $tables = config('jba-profile.table_names');

        if(isset($tables[$table])) {
            return $tables[$table];
        }

        throw new \ErrorException('Invalid table name in ' . __FUNCTION__);
    }
}