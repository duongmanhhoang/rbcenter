<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassRequest extends FormRequest
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
            'image' => 'required|mimes:jpg,jpeg,png|max:2000',
            'name' => 'required|max:191|regex:/^[^.]+$/',
            'start_day' => 'required',
            'end_day' => 'required|after:start_day'
        ];
    }

    public function messages()
    {
        return [
            'image.required' => 'Vui lòng chọn ảnh',
            'image.mimes' => "Vui lòng chỉ chọn file định dạng jpg,jpeg,png",
            'image.max' => 'Vui lòng không chọn file lớn hơn 2MB',
            'name.required' => 'Vui lòng nhập tên lớp học',
            'name.max' => 'Vui lòng không nhập quá 191 ký tự',
            'name.regex' => 'Tên lớp học không được chứa ký tứ "."',
            'start_day.required' => 'Vui lòng chọn ngày bắt đầu lớp học',
            'end_day.required' => 'Vui lòng chọn ngày kết thúc lớp học',
            'end_day.after' => 'Ngày kết thục phải sau ngày bắt đầu'
        ];
    }
}
