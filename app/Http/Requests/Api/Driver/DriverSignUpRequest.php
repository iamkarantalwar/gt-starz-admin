<?php

namespace App\Http\Requests\Api\Driver;

use App\Http\Requests\Api\ApiRequest;

class DriverSignUpRequest extends ApiRequest
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
            'name' => 'required',
            'username' => 'required|unique:drivers,username',
            'email' => 'required|unique:drivers,email|email',
            'phone_number' => 'required|unique:drivers,phone_number|numeric',
            'password' => 'required|same:confirm_password|min:6',
            'confirm_password' => 'required',
        ];
    }
}
