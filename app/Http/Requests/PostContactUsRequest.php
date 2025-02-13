<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostContactUsRequest extends FormRequest
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
        $this->redirect = url()->previous() . '#contactusform';
        
        return [
            'name' => 'required|max:50',
            'email' => 'required|email',
            'message' => 'required',
        ];
    }
}
