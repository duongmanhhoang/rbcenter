<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'image' => 'required|mimes:jpg,png,jpeg|max:2000',
            'name' => 'required|max:191|regex:/^[^.]+$/',
            'cate_id' => 'required',
            'price' => 'nullable|numeric|max:9999999999|min:1000',
            'sale_price' => 'nullable|numeric|min:1000',
        ];
    }

    public function messages()
    {
        return [
            'image.required' => 'Vui lòng chọn ảnh sản phẩm',
            'image.mimes' => 'Vui lòng chỉ chọn file jpg,jpeg,png',
            'image.max' => 'Vui lòng không dùng ảnh có dung lượng lớn hơn 2MB',
            'name.required' => 'Vui lòng nhập tên sản phẩm',
            'name.max' => 'Vui lòng không nhập quá 191 ký tự',
            'name.regex' => 'Tên sản phẩm không được chứa ký tự "."',
            'cate_id.required' => 'Vui lòng chọn danh mục',
            'price.numeric' => 'Vui lòng chỉ nhập số',
            'price.max' => 'Vui lòng không nhập giá quá 9999999999',
            'price.min' => 'Vui lòng không nhập giá nhỏ hơn 1000',
            'sale_price.numeric' => 'Vui lòng nhập chỉ số',
            'sale_price.min' => 'Vui lòng không nhập giá nhỏ hơn 1000',
            'sale_price.lt' => 'Vui lòng không nhập giá khuyến mãi lớn hơn giá gốc'
        ];
    }
}
