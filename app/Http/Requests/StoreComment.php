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
            'article_id' => 'required|integer|min:1',
            'user_id'    => 'required|integer|min:1',
            'comment'    => 'required|String|min:3|max:1000',
        ];
    }//end rules()


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'article_id.required' => 'The new comment must be assigned to an article.',
            'user_id.required'    => 'The new comment must be created by user.',
            'comment.required'    => 'The comment body shouldn\'t be blank!',
        ];
    }//end messages()

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {

        $this->sanitizeInput();

        return parent::getValidatorInstance();
    }

    /**
     * Sanitize and double check the input form data.
     *
     * @return array
     */
    public function sanitizeInput()
    {
        $input = $this->all();
        
        $input['comment'] = filter_var($input['comment'], FILTER_SANITIZE_STRING);

        $this->replace($input);
    }
}//end class
