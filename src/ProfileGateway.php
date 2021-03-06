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
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;
use JoyBusinessAcademy\Profile\Events\ProfileUpdated;
use JoyBusinessAcademy\Profile\Exceptions\ProfileException;
use JoyBusinessAcademy\Profile\Models\Profile;
use JoyBusinessAcademy\Profile\Models\Resume;
use JoyBusinessAcademy\Profile\Repositories\EducationRepository;
use JoyBusinessAcademy\Profile\Repositories\ExperienceRepository;
use JoyBusinessAcademy\Profile\Repositories\ReferenceRepository;
use JoyBusinessAcademy\Profile\Repositories\RegionRepository;
use JoyBusinessAcademy\Profile\Repositories\ResumeRepository;

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
    protected $profileRepository;

    /**
     * @var RegionRepository
     */
    protected $regionRepository;

    /**
     * @var ReferenceRepository
     */
    protected $referenceRepository;

    /**
     * @var EducationRepository
     */
    protected $educationRepository;

    /**
     * @var ExperienceRepository
     */
    protected $experienceRepository;

    /**
     * @var ResumeRepository
     */
    protected $resumeRepository;


    public function __construct(CacheManager $cacheManager)
    {
        $this->cacheManager = $cacheManager;

        $profileRepo = config('jba-profile.repositories.profile');

        $this->profileRepository = new $profileRepo($this);

        $referenceRepo = config('jba-profile.repositories.reference');

        $this->referenceRepository = new $referenceRepo($this);

        $educationRepo = config('jba-profile.repositories.education');

        $this->educationRepository = new $educationRepo($this);

        $experienceRepo = config('jba-profile.repositories.experience');

        $this->experienceRepository = new $experienceRepo($this);

        $resumeRepo = config('jba-profile.repositories.resume');

        $this->resumeRepository = new $resumeRepo($this);

        $skillRepo = config('jba-profile.repositories.skill');

        $this->skillRepository = new $skillRepo($this);

        $this->initializeCache();
    }

    protected function initializeCache()
    {
        self::$cacheExpirationTime = config('jba-profile.cache.expiration_time', 86400);

        if(app()->version() <= '5.5') {
            if(self::$cacheExpirationTime instanceof \DateInterval) {
                $interval = self::$cacheExpirationTime;
                self::$cacheExpirationTime = $interval->m * 30 * 60 * 24 + $interval->d * 60 * 24 + $interval->h * 60 + $interval->i;
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

    public function forgetCachedProfile()
    {
        $this->cache->forget($this->generateCacheKey());
        $this->profile = null;
    }

    protected function generateCacheKey(Model $user = null)
    {
        if($user) {
            return self::$cacheKey . 'user_' . $user->id . '_profile';
        }
        else if($this->profile) {
            return self::$cacheKey . 'user_' . $this->profile->user_id . '_profile';
        }

        return null;

    }

    public function getUserProfile(Model $user)
    {
        if($this->profile && ($this->profile->user->id == $user->id)) {

            return $this->profile;
        }

        $this->profile = $this->cache->remember($this->generateCacheKey($user), self::$cacheExpirationTime, function() use ($user){

            $user->load('profile');

            if(!$user->profile && config('jba-profile.attributes.profile.auto_create')) {

                $data = [];

                foreach(config('jba-profile.attributes.profile.auto_create') as $key => $default) {
                    $data[$key] = $user->{$key} ?: $default;
                }


                $user->profile()->create($data);

                $user->load('profile');
            }

            if($user->profile) {

                $relations = ['user', 'region', 'experiences', 'educations', 'skills'];

                if(config('jba-profile.attributes.resume.multiple')) {
                    $relations[] = 'resumes';
                }
                else {
                    $relations[] = 'resume';
                }

                $user->profile->load($relations);
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

    public function saveUserProfile(Model $user, array $profile)
    {
        return $this->profileRepository->saveUserProfile($user, $profile);
    }

    public function addOneProfileExperience(Model $user, $experience)
    {
        return $this->experienceRepository->addOneProfileExperience($user, $experience);
    }

    public function deleteOneProfileExperience(Model $user, $experience)
    {
        return $this->experienceRepository->deleteOneProfileExperience($user, $experience);
    }

    public function addProfileExperiences(Model $user, $experiences)
    {
        return $this->experienceRepository->addProfileExperiences($user, $experiences);
    }

    public function deleteProfileExperiences(Model $user, array $experienceIds)
    {
        return $this->experienceRepository->deleteProfileExperiences($user, $experienceIds);
    }

    public function updateOneProfileExperience(Model $user, $data)
    {
        return $this->experienceRepository->updateOneProfileExperience($user, $data);
    }

    public function addOneProfileEducation(Model $user, $education)
    {
        return $this->educationRepository->addOneProfileEducation($user, $education);
    }

    public function addProfileEducations(Model $user, $educations)
    {
        return $this->educationRepository->addProfileEducations($user, $educations);
    }

    public function updateOneProfileEducation(Model $user, $data)
    {
        return $this->educationRepository->updateOneProfileEducation($user, $data);
    }

    public function deleteOneProfileEducation(Model $user, $education)
    {
        return $this->educationRepository->deleteOneProfileEducation($user, $education);
    }

    public function deleteProfileEducations(Model $user, array $educationIds)
    {
        return $this->educationRepository->deleteProfileEducations($user, $educationIds);
    }

    public function addOneProfileReference(Model $user, $reference)
    {
        return $this->referenceRepository->addOneProfileReference($user, $reference);
    }

    public function addProfileReferences(Model $user, $references)
    {
        return $this->referenceRepository->addProfileReferences($user, $references);
    }

    public function updateOneProfileReference(Model $user, $data)
    {
        return $this->referenceRepository->updateOneProfileReference($user, $data);
    }

    public function deleteOneProfileReference(Model $user, Model $reference)
    {
        return $this->referenceRepository->deleteOneProfileReference($user, $reference);
    }

    public function deleteProfileReferences(Model $user, array $referenceIds)
    {
        return $this->referenceRepository->deleteProfileReferences($user, $referenceIds);
    }

    public function uploadProfileResume(Model $user, UploadedFile $file)
    {
        return $this->resumeRepository->uploadProfileResume($user, $file);
    }

    public function deleteProfileResume(Model $user, Resume $resume = null)
    {
        return $this->resumeRepository->deleteProfileResume($user, $resume);
    }

    public function getProfileResumeContent(Resume $resume)
    {
        return $this->resumeRepository->getResumeContent($resume);
    }

    public function setDefaultProfileResume(Model $user, Resume $resume)
    {
        return $this->resumeRepository->setDefaultProfileResume($user, $resume);
    }

    public function addOneProfileSkill(Model $user, $skill)
    {
        return $this->skillRepository->addOneProfileSkill($user, $skill);
    }

    public function addProfileSkills(Model $user, $skills)
    {
        return $this->skillRepository->addProfileSkills($user, $skills);
    }

    public function updateOneProfileSkill(Model $user, $data)
    {
        return $this->skillRepository->updateOneProfileSkill($user, $data);
    }

    public function deleteOneProfileSkill(Model $user, Model $skill)
    {
        return $this->skillRepository->deleteOneProfileSkill($user, $skill);
    }

    public function deleteProfileSkills(Model $user, array $skillIds)
    {
        return $this->skillRepository->deleteProfileSkills($user, $skillIds);
    }

    public function cleanProfileSkills(Model $user)
    {
        return $this->skillRepository->cleanProfileSkills($user);
    }
/*
    public function __call($method, ...$arguments)
    {
        $snakeCase = strtolower(preg_replace('/\B([A-Z])/', '_$1', $method));
        $words = explode('_', $snakeCase);
        $lastWord = array_pop($words);

        $repository = $lastWord . 'Repository';

        if(property_exists($this, $repository)) {
            $this->$repository->$method($arguments);
        }

    }*/
}