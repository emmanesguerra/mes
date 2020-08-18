<?php

namespace Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreOfficeRequest extends FormRequest
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
            return Auth::user()->hasPermissionTo('offices-create', true);
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
            'address' => 'required|max:65535',
            'contact_person' => 'max:191',
            'telephone' => 'max:100',
            'mobile' => 'max:100',
            'email' => 'max:100',
            'marker' => 'required|max:65535',
            'm_width' => 'required',
            'm_height' => 'required',
            'store_hours' => 'max:65535',
        ];
    }
}
