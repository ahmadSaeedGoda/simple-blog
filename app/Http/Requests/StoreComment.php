<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreComment extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'article_id' => 'required|integer',
            'user_id' => 'required|integer',
            'comment' => 'required|min:3|max:1000',
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
            'article_id.required' => 'The new comment must be assigned to an article.',
            'user_id.required' => 'The new comment must be created by user.',
            'comment.required'  => 'The comment body shouldn\'t be blank!',
        ];
    }
}
