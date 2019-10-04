<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 9/24/2019
 * Time: 8:22 PM
 */

namespace JoyBusinessAcademy\Profile\Tests\Unit;

use JoyBusinessAcademy\Profile\Facades\JbaProfile;
use JoyBusinessAcademy\Profile\Models\Education;
use JoyBusinessAcademy\Profile\Models\Experience;
use JoyBusinessAcademy\Profile\Models\Profile;
use JoyBusinessAcademy\Profile\Models\Reference;
use JoyBusinessAcademy\Profile\Models\User;
use JoyBusinessAcademy\Profile\Tests\TestCase;

class ProfileTest extends TestCase
{
    protected $user;


    /** @test */
    public function create_a_user_with_the_factory()
    {
        $user = $this->createUser();

        $this->assertGreaterThan(0, $user->id);

        return $user;
    }

    /**
     * @test
     * @depends create_a_user_with_the_factory
     */
    public function update_the_user_profile($user)
    {
        $data = factory(Profile::class)->raw();

        \JoyBusinessAcademy\Profile\Facades\JbaProfile::updateProfile($user, $data);

        $profile = \JoyBusinessAcademy\Profile\Facades\JbaProfile::getUserProfile($user);

        $this->assertEquals($user->id, $profile->user_id);
        $this->assertEquals($data['region_id'], $profile->region->id);
        $this->assertEquals($data['date_of_birth'], $profile->date_of_birth);
        $this->assertEquals($data['location'], $profile->location);
        $this->assertEquals($data['ethnicity'], $profile->ethnicity);
        $this->assertEquals($data['residency'], $profile->residency);
        $this->assertEquals($data['first_name'], $profile->first_name);
        $this->assertEquals($data['last_name'], $profile->last_name);
        $this->assertEquals($data['gender'], $profile->gender);
        $this->assertEquals($data['avatar'], $profile->avatar);
        $this->assertEquals($data['phone'], $profile->phone);
        $this->assertEquals($user->id, $profile->user_id);

        return $data;

    }

    /**
     * @test
     * @depends create_a_user_with_the_factory
     * @depends update_the_user_profile
     */
    public function get_the_user_profile($user, $data)
    {
        $profile = \JoyBusinessAcademy\Profile\Facades\JbaProfile::getUserProfile($user);

        $this->assertEquals($user->id, $profile->user_id);
        $this->assertEquals($data['region_id'], $profile->region->id);

    }

    /**
     * @test
     * @depends create_a_user_with_the_factory
     */
    public function add_one_profile_experience($user)
    {
        $experience = factory(Experience::class)->raw();

        JbaProfile::addOneProfileExperience($user, $experience);

        $profile = JbaProfile::getUserProfile($user);

        $this->assertEquals(count($profile->experiences), 1);

    }

    /**
     * @test
     * @depends create_a_user_with_the_factory
     */
    public function update_one_profile_experiences($user)
    {
        $profile = JbaProfile::getUserProfile($user);

        $experience = $profile->experiences->first();

        $old = $experience->toArray();

        $data = factory(Experience::class)->raw();

        JbaProfile::updateOneProfileExperience($user, $experience->fill($data)->toArray());

        $profile = JbaProfile::getUserProfile($user);

        $updated = $profile->experiences->first();

        $this->assertEquals($updated->location, $data['location']);
        $this->assertNotEquals($updated->location, $old['location']);

    }

    /**
     * @test
     * @depends create_a_user_with_the_factory
     */
    public function delete_one_profile_experience($user)
    {
        $this->deleteProfileExperiences($user);

        $profile = JbaProfile::getUserProfile($user);

        $this->assertEquals($profile->experiences->count(), 0);
    }


    /**
     * @test
     * @depends create_a_user_with_the_factory
     */
    public function add_multi_profile_experiences($user)
    {
        $multiExperiences = [];

        for ($i = 0; $i < 4; $i ++) {
            $multiExperiences[] = factory(Experience::class)->raw();
        }

        JbaProfile::addProfileExperiences($user, $multiExperiences);

        $profile = JbaProfile::getUserProfile($user);

        $this->assertEquals(count($profile->experiences), count($multiExperiences));
    }

    /**
     * @test
     * @depends create_a_user_with_the_factory
     */
    public function delete_multi_profile_experiences($user)
    {
        $this->deleteProfileExperiences($user);

        $profile = JbaProfile::getUserProfile($user);

        $this->assertEquals($profile->experiences->count(), 0);
    }

    /**
     * @test
     * @depends create_a_user_with_the_factory
     */
    public function add_one_profile_education($user)
    {
        $education = factory(Education::class)->raw();

        JbaProfile::addOneProfileEduction($user, $education);

        $profile = JbaProfile::getUserProfile($user);

        $this->assertEquals(count($profile->educations), 1);
    }

    /**
     * @test
     * @depends create_a_user_with_the_factory
     */
    public function update_one_profile_education($user)
    {
        $profile = JbaProfile::getUserProfile($user);

        $education = $profile->educations->first();

        $old = $education->toArray();

        $data = factory(Education::class)->raw();

        JbaProfile::updateOneProfileEducation($user, $education->fill($data)->toArray());

        $profile = JbaProfile::getUserProfile($user);

        $updated = $profile->educations->first();

        $this->assertEquals($updated->major, $data['major']);
        $this->assertNotEquals($updated->major, $old['major']);

    }

    /**
     * @test
     * @depends create_a_user_with_the_factory
     */
    public function delete_one_profile_education($user)
    {
        $this->deleteProfileEducations($user);

        $profile = JbaProfile::getUserProfile($user);

        $this->assertEquals($profile->educations->count(), 0);
    }


    /**
     * @test
     * @depends create_a_user_with_the_factory
     */
    public function add_multi_profile_educations($user)
    {
        $multiEducations = [];

        for ($i = 0; $i < 4; $i ++) {
            $multiEducations[] = factory(Education::class)->raw();
        }

        JbaProfile::addProfileEducations($user, $multiEducations);

        $profile = JbaProfile::getUserProfile($user);

        $this->assertEquals(count($profile->educations), count($multiEducations));
    }

    /**
     * @test
     * @depends create_a_user_with_the_factory
     */
    public function delete_multi_profile_educations($user)
    {
        $this->deleteProfileEducations($user);

        $profile = JbaProfile::getUserProfile($user);

        $this->assertEquals($profile->educations->count(), 0);
    }

    /**
     * @test
     * @depends create_a_user_with_the_factory
     */
    public function add_one_profile_reference($user)
    {
        $reference = factory(Reference::class)->raw();

        JbaProfile::addOneProfileReference($user, $reference);

        $profile = JbaProfile::getUserProfile($user);

        $this->assertEquals(count($profile->references), 1);
    }

    /**
     * @test
     * @depends create_a_user_with_the_factory
     */
    public function update_one_profile_reference($user)
    {
        $profile = JbaProfile::getUserProfile($user);

        $reference = $profile->references->first();

        $old = $reference->toArray();

        $data = factory(Reference::class)->raw();

        JbaProfile::updateOneProfileReference($user, $reference->fill($data)->toArray());

        $profile = JbaProfile::getUserProfile($user);

        $updated = $profile->references->first();

        $this->assertEquals($updated->company, $data['company']);
        $this->assertNotEquals($updated->company, $old['company']);

    }

    /**
     * @test
     * @depends create_a_user_with_the_factory
     */
    public function delete_one_profile_reference($user)
    {
        $this->deleteProfileReferences($user);

        $profile = JbaProfile::getUserProfile($user);

        $this->assertEquals($profile->references->count(), 0);
    }

    /**
     * @test
     * @depends create_a_user_with_the_factory
     */
    public function add_multi_profile_references($user)
    {
        $multiReferences = [];

        for ($i = 0; $i < 4; $i ++) {
            $multiReferences[] = factory(Reference::class)->raw();
        }

        JbaProfile::addProfileReferences($user, $multiReferences);

        $profile = JbaProfile::getUserProfile($user);

        $this->assertEquals(count($profile->references), count($multiReferences));
    }

    /**
     * @test
     * @depends create_a_user_with_the_factory
     */
    public function delete_multi_profile_references($user)
    {
        $this->deleteProfileReferences($user);

        $profile = JbaProfile::getUserProfile($user);

        $this->assertEquals($profile->references->count(), 0);
    }


    protected function deleteProfileEducations($user)
    {
        $profile = JbaProfile::getUserProfile($user);

        switch ($profile->educations->count()) {
            case 1: {
                JbaProfile::deleteOneProfileEducation($user, $profile->educations->first());
                break;
            }
            case 0: {
                break;
            }
            default: {
                $ids = $profile->educations->pluck('id')->toArray();
                JbaProfile::deleteProfileEducations($user, $ids);
                break;
            }
        }
    }

    protected function deleteProfileExperiences($user)
    {
        $profile = JbaProfile::getUserProfile($user);

        switch ($profile->experiences->count()) {
            case 1: {
                JbaProfile::deleteOneProfileExperience($user, $profile->experiences->first());
                break;
            }
            case 0: {
                break;
            }
            default: {
                $ids = $profile->experiences->pluck('id')->toArray();
                JbaProfile::deleteProfileExperiences($user, $ids);
                break;
            }
        }
    }

    protected function deleteProfileReferences($user)
    {
        $profile = JbaProfile::getUserProfile($user);

        switch ($profile->references->count()) {
            case 1: {
                JbaProfile::deleteOneProfileReference($user, $profile->references->first());
                break;
            }
            case 0: {
                break;
            }
            default: {
                $ids = $profile->references->pluck('id')->toArray();
                JbaProfile::deleteProfileReferences($user, $ids);
                break;
            }
        }
    }


    protected function createUser()
    {
        return factory(User::class)->create();
    }
}