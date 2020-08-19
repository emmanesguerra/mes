<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PostPageBannerRequest extends FormRequest
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
            return Auth::user()->hasPermissionTo('pagebanner-create', true);
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
            'page_id' => 'required|unique:pagebanners,page_id',
            'title' => 'required|max:191',
            'description' => 'max:191',
            'image' => 'required|max:191',
        ];
    }
}
