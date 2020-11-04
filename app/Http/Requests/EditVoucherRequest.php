<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditVoucherRequest extends FormRequest
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
            'name' => 'required|min:3|max:10',
            'description' => 'required|min:3|max:255',
            'quantity' => 'required|numeric',
            'min_value' => 'required|numeric',
            'discount' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('supplier.code_not_null'),
            'name.min' => trans('supplier.code_min'),
            'name.max' => trans('supplier.code_max'),
            'description.required' => trans('supplier.description_not_null'),
            'description.min' => trans('supplier.description_min_max'),
            'description.max' => trans('supplier.description_min_max'),
            'quantity.required' => trans('supplier.quantity_not_null'),
            'quantity.numberic' => trans('supplier.quantity_number'),
            'min_value.required' => trans('supplier.min_value_not_null'),
            'min_value.numberic' => trans('supplier.min_value_number'),
            'discount.required' => trans('supplier.discount_not_null'),
            'discount.numberic' => trans('supplier.discount_number'),
            'start_date.required' => trans('supplier.start_date_not_null'),
            'start_date.date' => trans('supplier.start_date_is_date'),
            'end_date.required' => trans('supplier.end_date_not_null'),
            'end_date.date' => trans('supplier.end_date_is_date'),
            'end_date.after_or_equal' => trans('supplier.end_date_after'),
        ];
    }
}
