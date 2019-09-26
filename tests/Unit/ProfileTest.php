<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 9/24/2019
 * Time: 8:22 PM
 */

namespace JoyBusinessAcademy\Profile\Tests\Unit;

use JoyBusinessAcademy\Profile\Models\Profile;
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

        \JoyBusinessAcademy\Profile\Facades\Profile::updateProfile($user, $data);

        $profile = \JoyBusinessAcademy\Profile\Facades\Profile::getUserProfile($user);

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
    public function get_the_user_profile($user)
    {
        $profile = \JoyBusinessAcademy\Profile\Facades\Profile::getUserProfile($user);

        $this->assertEquals($user->id, $profile->user_id);

    }

    protected function createUser()
    {
        return factory(User::class)->create();
    }
}