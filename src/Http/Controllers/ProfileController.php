<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 7/30/2020
 * Time: 9:30 AM
 */

namespace JoyBusinessAcademy\Profile\Controllers;

use Illuminate\Routing\Controller;
use JoyBusinessAcademy\Profile\Facades\JbaProfile;
use JoyBusinessAcademy\Profile\Http\Requests\CoverLetterRequest;

class ProfileController extends Controller
{
    public function updateCoverLetter(CoverLetterRequest $request)
    {
        JbaProfile::updateProfile($request->user(), ['cover_letter' => $request->cover_letter]);
        $profile = JbaProfile::getUserProfile($request->user());
        return $profile->cover_letter;
    }
}