<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class DriverRequest extends FormRequest
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
        if($this->method() == "POST")
        {
            return [
                'name' => 'required',
                'username' => 'required|unique:drivers,username',
                'email' => 'required|unique:drivers,email|email',
                'phone_number' => 'required|unique:drivers,phone_number|numeric',
                'password' => 'required|same:confirm_password|min:6',
                'confirm_password' => 'required',
                'address' => 'required'
            ];
        }
        else if($this->method == "PUT" || $this->method == "PATCH")
        {
            $driver = $this->route('driver');
            return [
                'name' => 'required',
                'username' => 'required|unique:drivers,username,'. $driver->id,
                'email' => 'required|email|unique:drivers,email,'. $driver->id,
                'phone_number' => 'required|numeric|unique:drivers,phone_number,'. $driver->id,
                'password' => 'nullable|same:confirm_password|min:6',
                'confirm_password' => 'same:password|nullable',
                'address' => 'required',
                'approved' => 'required|boolean'
            ];
        }

    }
}
