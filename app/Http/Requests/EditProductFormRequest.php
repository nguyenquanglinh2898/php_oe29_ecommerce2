<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditProductFormRequest extends FormRequest
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
            'name' => 'required|max:255',
            'weight' => 'required|max:100000',
            'brand' => 'max:255',
            'thumbnail' => 'mimes:jpeg,jpg,png,gif|max:20000',
            'category_id' => 'required',
            'attr.*' => 'required|distinct|max:255',
            'images.*' => 'mimes:jpeg,jpg,png,gif|max:20000',
            'remaining.*' => 'required',
            'price.*' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('sentences.name_is_required'),
            'name.max' => trans('sentences.name_too_long'),
            'weight.required' => trans('sentences.weight_is_required'),
            'weight.max' => trans('sentences.too_heavy'),
            'brand.max' => trans('sentences.brand_too_long'),
            'thumbnail.mimes' => trans('sentences.invalid_extension'),
            'category_id.required' => trans('sentences.category_is_required'),
            'attr.*.required' => trans('sentences.attr_is_required'),
            'attr.*.distinct' => trans('sentences.attr_must_distinct'),
            'attr.*.max' => trans('sentences.attr_too_long'),
            'images.*.mimes' => trans('sentences.invalid_extension'),
            'remaining.*.required' => trans('sentences.remaining_is_required'),
            'price.*.required' => trans('sentences.price_is_required'),
        ];
    }
}
