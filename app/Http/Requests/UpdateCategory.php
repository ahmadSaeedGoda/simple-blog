<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategory extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:categories|min:3|max:255'
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
            'name.required' => 'The article name shouldn\'t be blank!'
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
        
        $input['name'] = filter_var($input['name'], FILTER_SANITIZE_STRING);

        $this->replace($input);
    }
}//end class
