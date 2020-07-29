<?php
/**
 * Created by PhpStorm.
 * User: zhiya
 * Date: 7/30/2020
 * Time: 9:32 AM
 */

namespace JoyBusinessAcademy\Profile\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoverLetterRequest extends FormRequest
{
    public function authorize()
    {
        return request()->user();
    }

    public function rules()
    {
        return [
            'cover_letter' => 'required|min:' . config('jba-profile.attributes.cover_letter.max_size')
        ];
    }
}