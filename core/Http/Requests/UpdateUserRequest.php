<?php

namespace Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
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
            return Auth::user()->hasPermissionTo('users-edit', true);
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
        $userid = $this->route('user');
        
        return [
            'id' => 'required',
            'firstname' => 'required|max:50',
            'lastname' => 'max:50',
            'middlename' => 'max:50',
            'email' => 'required|email|unique:users,email,'.$userid,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ];
    }
}
