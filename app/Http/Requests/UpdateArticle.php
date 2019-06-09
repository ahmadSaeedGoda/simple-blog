<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticle extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_id' => 'required',
            'title' => 'required|max:255',
            'body' => 'required|min:3|max:3000',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'category_id.required' => 'The new article must be assigned to category!',
            'title.required' => 'A article title shouldn\'t be blank!',
            // 'title.unique' => 'Sorry! This title is already in use, Try something different.',
            'body.required'  => 'The article body shouldn\'t be blank!',
        ];
    }
}
