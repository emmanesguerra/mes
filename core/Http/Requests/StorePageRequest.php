<?php

namespace Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePageRequest extends FormRequest
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
            return Auth::user()->hasPermissionTo('pages-create', true);
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
            'name' => 'required',
            'title' => 'required',
            'url' => 'required|unique:pages,url',
            'description' => 'required|max:255',
            'template' => 'required',
            'contents.*.name' => 'sometimes|required',
            'contents.*.container_class' => 'sometimes|required',
            'contents.*.selected_panel' => 'sometimes|required',
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
            'contents.required' => 'Template contents are required.'
        ];
    }
}
