<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 7/28/2020
 * Time: 8:59 AM
 */

namespace JoyBusinessAcademy\Profile\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use JoyBusinessAcademy\Profile\Facades\JbaProfile;
use JoyBusinessAcademy\Profile\Http\Requests\ResumeRequest;
use JoyBusinessAcademy\Profile\Models\Resume;

class ResumeController extends Controller
{
    public function index(Request $request)
    {
        $profile = JbaProfile::getUserProfile($request->user());
        return config('jba-profile.attributes.resume.multiple') ? $profile->resumes : $profile->resume;
    }

    public function upload(ResumeRequest $request)
    {
        JbaProfile::uploadProfileResume($request->user(), $request->file('resume'));

        $profile = JbaProfile::getUserProfile($request->user());
        //TODO: better way to switch single and multiple resume(s)
        return config('jba-profile.attributes.resume.multiple') ? $profile->resumes : $profile->resume;
    }

    public function setDefault(Request $request, Resume $resume)
    {
        JbaProfile::setDefaultProfileResume($request->user(), $resume);
        $profile = JbaProfile::getUserProfile($request->user());
        //TODO: better way to switch single and multiple resume(s)
        return config('jba-profile.attributes.resume.multiple') ? $profile->resumes : $profile->resume;
    }

    public function remove(Request $request, Resume $resume = null)
    {
        JbaProfile::deleteProfileResume($request->user(), $resume);

        $profile = JbaProfile::getUserProfile($request->user());
        //TODO: better way to switch single and multiple resume(s)
        return config('jba-profile.attributes.resume.multiple') ? $profile->resumes : $profile->resume;
    }

    /*public function download(Request $request, Resume $resume)
    {
        $content = JbaProfile::getProfileResumeContent($resume);

        $headers = [
            'Content-Type' => $resume->file_type,
            'Content-Disposition' => 'attachment',
            'filename' => $resume->file_name
        ];

        return response()->download($content, $resume->file_name, $headers);
    }*/
}