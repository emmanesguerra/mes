<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostDownloadablesRequest extends FormRequest
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
            return Auth::user()->hasPermissionTo('downloadables-create', true);
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
            'directory' => 'required|unique:downloadables,directory'
        ];
    }
}
