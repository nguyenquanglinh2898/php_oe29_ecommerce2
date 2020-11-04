<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'current-password.required' => trans('customer.password_is_required'),
            'new-password.required' =>  trans('customer.new_password_is_required'),
            'new-password.string' => trans('customer.password_string'),
            'new-password.min' => trans('customer.password_min'),
        ];
    }
}
