<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 9/23/2019
 * Time: 10:50 AM
 */

namespace JoyBusinessAcademy\Profile;


use Illuminate\Cache\CacheManager;
use Illuminate\Database\Eloquent\Model;
use JoyBusinessAcademy\Profile\Exceptions\ProfileException;
use JoyBusinessAcademy\Profile\Models\Profile;
use JoyBusinessAcademy\Profile\Repositories\RegionRepository;

class ProfileGateway
{

    /**
     * @var \Illuminate\Contracts\Cache\Repository
     */
    protected $cache;

    /**
     * @var \Illuminate\Cache\CacheManager
     */
    protected $cacheManager;

    /**
     * @var \DateInterval|int
     */
    public static $cacheExpirationTime;

    /**
     * @var string
     */
    public static $cacheKey;

    /**
     * @var Profile
     */
    protected $profile;

    /**
     * @var string
     */
    protected $profileClass;

    /**
     * @var RegionRepository
     */
    protected $regionRepository;


    public function __construct(CacheManager $cacheManager)
    {
        $this->cacheManager = $cacheManager;

        $this->profileClass = config('jba-profile.models.profile');

        $this->initializeCache();
    }

    protected function initializeCache()
    {
        self::$cacheExpirationTime = config('jba-profile.cache.expiration_time', 86400);

        if(app()->version() <= '5.5') {
            if(self::$cacheExpirationTime instanceof \DateInterval) {
                $interval = self::$cacheExpirationTime;
                self::$cacheExpirationTime = $interval->m * 30 * 60 * 24 + $interval->id * 60 * 24 + $interval->h * 60 + $interval->i;
            }
        }

        self::$cacheKey = config('jba-profile.cache.key');

        $this->cache = $this->getCacheStoreFromConfig();
    }

    protected function getCacheStoreFromConfig(): \Illuminate\Contracts\Cache\Repository
    {
        $cacheDriver = config('jba-profile.cache.store', 'default');

        if($cacheDriver === 'default') {
            return $this->cacheManager->store();
        }

        if(! array_key_exists($cacheDriver, config('cache.stores'))) {
            $cacheDriver = 'array';
        }

        return $this->cacheManager->store($cacheDriver);
    }

    public function instantiate($name, ...$arguments)
    {
        if($class = config('jba-profile.' . $name, null)) {
            return new $class(...$arguments);
        }

        throw new ProfileException('Instance object \'' . $name . '\' not found');
    }

    public function getCacheStore(): \Illuminate\Contracts\Cache\Store
    {
        return $this->cache->getStore();
    }



    public function forgetCachedProfile($model)
    {
        $this->profile = null;
        $this->cache->forget($this->generateCacheKey($model));
    }

    protected function generateCacheKey($model)
    {
        switch(get_class($model)) {
            case $this->profileClass: {
                return self::$cacheKey . 'user_' . $model->user_id . '_profile';
            }
            default: {
                break;
            }
        }

        return self::$cacheKey . 'user_' . $model->id . '_profile';
    }

    public function getUserProfile(Model $user)
    {
        if($this->profile && ($this->profile->user->id == $user->id)) {

            return $this->profile;
        }

        $this->profile = $this->cache->remember($this->generateCacheKey($user), self::$cacheExpirationTime, function() use ($user){

            $user->load('profile');

            if($user->profile) {
                $user->profile->load(['user', 'region']);
            }

            return $user->profile;
        });

        return $this->profile;
    }

    public function updateProfile(Model $user, array $data)
    {
        if($this->getUserProfile($user) == null) {

            $model = $this->instantiate('models.profile', $data);

            $user->profile()->save($model);

        }
        else {
            $user->profile->update($data);
        }

        return true;
    }
}