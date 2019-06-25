<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticle extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_id'  => 'required|integer|min:1',
            'title'        => 'required|String|unique:articles|max:255',
            'is_published' => 'boolean',
            'body'         => 'required|String|min:3|max:3000',
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
            'category_id.required' => 'The new article must be assigned to category!',
            'title.required'       => 'A article title shouldn\'t be blank!',
            'body.required'        => 'The article body shouldn\'t be blank!',
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
        
        $input['title'] = filter_var($input['title'], FILTER_SANITIZE_STRING);
        $input['body'] = filter_var($input['body'], FILTER_SANITIZE_STRING);
        
        if (!empty($input['is_published'])) {
            $input['is_published'] = true;
        } else {
            $input['is_published'] = false;
        }
        $this->replace($input);
    }
}//end class
