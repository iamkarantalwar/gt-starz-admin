<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        if($this->method() == "POST") {
            return [
                'category_name' => 'required|unique:categories,category_name',
                'image' => 'required|required|mimes:jpeg,png,jpg,gif,svg'
            ];
        } else if($this->method == "PUT" || $this->method == "PATCH") {
            $category = $this->route('categories');
            return [
                'category_name' => 'required|unique:categories,category_name,'.$category->id,
                'image' => 'image|required|mimes:jpeg,png,jpg,gif,svg'
            ];
        }

    }
}
