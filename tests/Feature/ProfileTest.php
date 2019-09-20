<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 9/20/2019
 * Time: 10:43 AM
 */

namespace JoyBusinessAcademy\Profile\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use JoyBusinessAcademy\Profile\Models\Profile;
use JoyBusinessAcademy\Profile\Tests\TestCase;

class ProfileTest extends TestCase
{

    /** @test */
    public function a_profile_can_be_created_with_the_factory()
    {
        $profile = factory(Profile::class)->create();

        $this->assertCount(1, Profile::all());
    }
}