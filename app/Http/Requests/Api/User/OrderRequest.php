<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\Api\ApiRequest;

class OrderRequest extends ApiRequest
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
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'phone_number' => 'required',
        ];
    }
}
