<?php

namespace JoyBusinessAcademy\Profile;

use Aws\Laravel\AwsServiceProvider;
use Aws\S3\S3Client;
use Illuminate\Cache\CacheManager;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Collection;
use League\Flysystem\AwsS3v3\AwsS3Adapter;

class ProfileServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //$this->loadRoutesFrom(__DIR__ . '/../routes');


        $this->registerRoutes();

        $this->mergeConfigFrom(__DIR__ . '/../config/jba-profile.php', 'jba-profile');
        //$this->mergeConfigFrom(__DIR__ . '/../config/filesystems.php', 'filesystems');


        $this->registerBladeExtensions();


    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(CacheManager $cacheManager, Filesystem $filesystem)
    {
        //$this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->registerPublishing($filesystem);

        //$this->registerS3Storage();

        if($this->app->runningInConsole()) {
            $this->commands([

            ]);
        }


        $this->app->singleton('JBAProfileGateway', function($app) use($cacheManager) {

            $gateway = $app->config['jba-profile.gateway'];

            return new $gateway($cacheManager);
        });
    }

    protected function registerS3Storage()
    {

        Storage::extend('s3', function($app) {
            $client = new S3Client([
                'credentials' => [
                    'key'    => $app->config['jba-profile.storage.s3.credentials.key'],
                    'secret' => $app->config['jba-profile.storage.s3.credentials.secret'],
                ],
                'region' => $app->config['jba-profile.storage.s3.region'],
                'version' => $app->config['jba-profile.storage.s3.version'],
             //   'endpoint' => $config['endpoint'],
                'ua_append' => [
                    'L5MOD/' . AwsServiceProvider::VERSION,
                ],
            ]);

            return new Filesystem(new AwsS3Adapter($client, $app->config['jba-profile.storage.s3.bucket']));
        });
    }

    protected function registerModelBindings()
    {
        //$config = $this->app->config['jba-profile.models'];

    }

    protected function registerPublishing($filesystem)
    {
        if(self::isNotLumen()) {

            $this->publishes([
                __DIR__ . '/../config/jba-profile.php' => config_path('jba-profile.php')

            ], 'jba-profile-config');

            $this->publishes([
                __DIR__ . '/../database/migrations/0000_00_00_000001_create_jba_profile_regions_table.php' => $this->getMigrationFileName($filesystem, 'create_jba_profile_regions_table.php'),
                __DIR__ . '/../database/migrations/0000_00_00_000003_create_jba_profile_profiles_table.php' => $this->getMigrationFileName($filesystem, 'create_jba_profile_profiles_table.php'),
                __DIR__ . '/../database/migrations/0000_00_00_000004_create_jba_profile_experiences_table.php' => $this->getMigrationFileName($filesystem, 'create_jba_profile_experiences_table.php'),
                __DIR__ . '/../database/migrations/0000_00_00_000004_update_jba_profile_profiles_table.php' => $this->getMigrationFileName($filesystem, 'update_jba_profile_profiles_table.php'),
                __DIR__ . '/../database/migrations/0000_00_00_000004_create_jba_profile_educations_table.php' => $this->getMigrationFileName($filesystem, 'create_jba_profile_educations_table.php'),
                __DIR__ . '/../database/migrations/0000_00_00_000004_create_jba_profile_references_table.php' => $this->getMigrationFileName($filesystem, 'create_jba_profile_references_table.php'),
                __DIR__ . '/../database/migrations/0000_00_00_000005_create_jba_profile_resumes_table.php' => $this->getMigrationFileName($filesystem, 'create_jba_profile_resumes_table.php'),
            ], 'jba-profile-migrations');

            $this->publishes([
                __DIR__ . '/../database/seeds/RegionSeeder.php' => $this->getSeederFileName($filesystem, 'RegionSeeder.php'),
            ], 'jba-profile-seeds');
        }
    }

    public static function isNotLumen() : bool
    {
        return ! preg_match('/lumen/i', app()->version());
    }

    protected function getMigrationFileName(Filesystem $filesystem, $fileName): string
    {
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

    protected function registerRoutes()
    {
        Route::group([
            'prefix' => 'jba-profile'
        ], function(){
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });
    }

    protected function registerBladeExtensions()
    {
        // define blade directive here for package
    }
}
