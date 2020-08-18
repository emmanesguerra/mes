<?php

namespace Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreMenuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        try
        {
            return Auth::user()->hasPermissionTo('menus-create', true);
        } catch (\Exception $ex) {
            return abort(403, "Action Denied. This account doesn't have authorization to continue this process.");
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nTitle' => 'required_without:pageId|unique:menus,title|max:46',
            'pageId' => 'gt:0',
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
            'nTitle.required_without' => 'This field is required',
            'nTitle.unique' => 'This title has already been taken',
            'nTitle.max' => 'This title may not be greater than 46 characters',
            'pageId.gt' => 'Please select a page'
        ];
    }
}
