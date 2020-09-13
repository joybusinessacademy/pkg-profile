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
        $this->registerRoutes();

        $this->mergeConfigFrom(__DIR__ . '/../config/jba-profile.php', 'jba-profile');

        $this->registerBladeExtensions();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(CacheManager $cacheManager, Filesystem $filesystem)
    {
        $this->registerPublishing($filesystem);

        if($this->app->runningInConsole()) {
            $this->commands([

            ]);
        }


        $this->app->singleton('JBAProfileGateway', function($app) use($cacheManager) {

            $gateway = $app->config['jba-profile.gateway'];

            return new $gateway($cacheManager);
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
                __DIR__ . '/../database/migrations/0000_00_00_000001_create_jba_profile_regions_table.php.stub' => $this->getMigrationFileName($filesystem, 'create_jba_profile_regions_table.php', 10),
                __DIR__ . '/../database/migrations/0000_00_00_000003_create_jba_profile_profiles_table.php.stub' => $this->getMigrationFileName($filesystem, 'create_jba_profile_profiles_table.php', 20),
                __DIR__ . '/../database/migrations/0000_00_00_000004_create_jba_profile_experiences_table.php.stub' => $this->getMigrationFileName($filesystem, 'create_jba_profile_experiences_table.php', 30),
                __DIR__ . '/../database/migrations/0000_00_00_000004_update_jba_profile_profiles_table.php.stub' => $this->getMigrationFileName($filesystem, 'update_jba_profile_profiles_table.php', 40),
                __DIR__ . '/../database/migrations/0000_00_00_000004_create_jba_profile_educations_table.php.stub' => $this->getMigrationFileName($filesystem, 'create_jba_profile_educations_table.php', 50),
                __DIR__ . '/../database/migrations/0000_00_00_000004_create_jba_profile_references_table.php.stub' => $this->getMigrationFileName($filesystem, 'create_jba_profile_references_table.php', 60),
                __DIR__ . '/../database/migrations/0000_00_00_000005_create_jba_profile_resumes_table.php.stub' => $this->getMigrationFileName($filesystem, 'create_jba_profile_resumes_table.php', 70),
                __DIR__ . '/../database/migrations/0000_00_00_000006_update_jba_profile_resumes_table.php.stub' => $this->getMigrationFileName($filesystem, 'update_jba_profile_resumes_table.php', 80),
                __DIR__ . '/../database/migrations/0000_00_00_000007_add_cover_letter_to_jba_profiles_table.php.stub' => $this->getMigrationFileName($filesystem, 'add_cover_letter_to_jba_profiles_table.php', 90),
                __DIR__ . '/../database/migrations/0000_00_00_000008_create_jba_profile_skills_table.php.stub' => $this->getMigrationFileName($filesystem, 'create_jba_profile_skills_table.php', 100),
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

    protected function getMigrationFileName(Filesystem $filesystem, $fileName, $order): string
    {
        $timestamp = date('Y_m_d_') . (date('His') + $order);

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
        if(config('jba-profile.route')) {
            Route::group([
                'prefix' => config('jba-profile.route.prefix'),
                'namespace' => config('jba-profile.route.namespace'),
                'middleware' => config('jba-profile.route.middleware'),
                'name' => config('jba-profile.route.prefix_name')
            ], function () {
                if (method_exists($this, 'loadRoutesFrom')) {
                    $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
                } else {
                    require __DIR__ . '/../routes/web.php';
                }
            });
        }
    }

    protected function registerBladeExtensions()
    {
        // define blade directive here for package
    }
}
