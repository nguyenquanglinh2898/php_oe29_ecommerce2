<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:20',
            'phone' => 'required|string|size:10|regex:/^0[^6421][0-9]{8}$/',
            'address' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('customer.name_is_required'),
            'name.string' => trans('customer.name_is_string'),
            'name.max' => trans('customer.name_max'),
            'phone.required' => trans('phone.name_is_required'),
            'phone.string' => trans('customer.phone_is_string'),
            'phone.size' => trans('customer.phone_size'),
            'phone.regex' => trans('customer.phone_invalid'),
            'address.required' => trans('customer.address_is_required'),
        ];
    }
}
