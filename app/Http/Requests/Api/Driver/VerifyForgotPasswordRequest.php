<?php

namespace App\Http\Requests\Api\Driver;

use App\Http\Requests\Api\ApiRequest;

class VerifyForgotPasswordRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|exists:drivers,email',
            'otp' => 'required|min:'.config('constant.otp.length'),
        ];
    }
}
