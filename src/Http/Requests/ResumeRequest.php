<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 7/28/2020
 * Time: 2:43 PM
 */

namespace JoyBusinessAcademy\Profile\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class ResumeRequest extends FormRequest
{
    public function authorize()
    {
        return request()->user();
    }

    public function rules()
    {
        return [
            'resume' => 'required|mimes:' . config('jba-profile.attributes.resume.mime_types') . '|max:' . config('jba-profile.attributes.resume.max_size')
        ];
    }
}