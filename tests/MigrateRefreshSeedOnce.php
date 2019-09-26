<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 9/25/2019
 * Time: 7:35 PM
 */

namespace JoyBusinessAcademy\Profile\Tests;


use Illuminate\Support\Facades\Artisan;

trait MigrateRefreshSeedOnce
{

    /**
     * If true, setup has run at least once.
     * @var boolean
     */
    protected static $setUpHasRunOnce = false;

    /**
     * After the first run of setUp "migrate:fresh --seed"
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        if (!static::$setUpHasRunOnce) {
            Artisan::call('migrate:fresh');
            Artisan::call(
                'db:seed', ['--class' => 'DatabaseSeeder', '--path' => __DIR__ . '/../database/seeds']
            );
            static::$setUpHasRunOnce = true;
        }

        $this->prepareForTests();
    }
}