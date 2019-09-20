<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 9/19/2019
 * Time: 10:42 PM
 */

namespace JoyBusinessAcademy\Profile;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\Filesystem;

class ProfileServiceProvider extends ServiceProvider
{
    public function boot(Filesystem $filesystem)
    {

        $this->publishes([
            __DIR__ . '/../config/jba-profile.php' => config_path('jba-profile.php')
        ], 'config');

        $this->publishes([
            __DIR__ . '/../database/migrations/0000_00_00_000001_create_jba_profile_regions_table.php' => $this->getMigrationFileName($filesystem, 'create_jba_profile_regions_table.php'),
            __DIR__ . '/../database/migrations/0000_00_00_000003_create_jba_profile_profiles_table.php' => $this->getMigrationFileName($filesystem, 'create_jba_profile_profiles_table.php')
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/../database/seeds/RegionSeeder.php' => $this->getSeederFileName($filesystem, 'RegionSeeder.php'),
        ], 'seeds');

        $this->app->singleton('JBAProfile', function($app) {

            $handler = $app['config']->get('jba-profile.handlers.profile');

            return new $handler();
        });

        $this->app->singleton('JBAProfileRegion', function($app){
            $handler = $app['config']->get('jba-profile.handlers.region');

            return new $handler();
        });
    }

    public function register()
    {
        //$this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    protected function getMigrationFileName(Filesystem $filesystem, $fileName): string
    {
        sleep(1);

        $timestamp = date('Y_m_d_His');

        return Collection::make($this->app->databasePath() . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR)
            ->flatMap(function ($path) use ($filesystem, $fileName) {
                return $filesystem->glob($path . '*_' . $fileName);
            })->push($this->app->databasePath() . '/migrations/' . $timestamp . '_' . $fileName)
            ->first();
    }

    protected function getSeederFileName(Filesystem $filesystem, $fileName): string
    {

        return Collection::make($this->app->databasePath() . DIRECTORY_SEPARATOR . 'seeds' . DIRECTORY_SEPARATOR)
            ->flatMap(function ($path) use ($filesystem, $fileName) {
                return $filesystem->glob($path . $fileName);
            })->push($this->app->databasePath() . '/seeds/' . $fileName)
            ->first();
    }
}