<?php

namespace Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreMenuSettingRequest extends FormRequest
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
            return Auth::user()->hasPermissionTo('menus-edit', true);
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
            'menu_id' => 'required',
            'blck_start' => 'required|max:150', 
            'blck_end' => 'required|max:10', 
            'list_dflt' => 'required|max:150', 
            'list_dflt_active' => 'required|max:150', 
            'list_chld' => 'required|max:150', 
            'list_end' => 'required|max:10', 
            'anch_dflt' => 'required|max:150', 
            'anch_chld' => 'required|max:150',
            'subblck_start' => 'max:150', 
            'subblck_end' => 'max:10', 
            'sublist_dflt' => 'max:150', 
            'sublist_chld' => 'max:150', 
            'sublist_end' => 'max:10', 
            'subanch_dflt' => 'max:150', 
            'subanch_chld' => 'max:150'
        ];
    }
}
