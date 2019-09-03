<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'image' => 'nullable|mimes:jpg,png,jpeg|max:2000',
            'title' => 'required|max:191|regex:/^[^.]+$/',
            'description' => 'required',
            'body' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'image.mimes' => 'Chỉ chấp nhận những file định dạng jpg, jpeg, png',
            'image.max' => 'Vui lòng không dùng file có dung lượng quá 2MB',
            'title.required' => 'Vui lòng nhập tiêu đề bài viết',
            'title.max' => 'Vui lòng không nhập quá 191 ký tự',
            'title.regex' => 'Vui lòng không sử dụng ký tự "."',
            'description.required' => 'Vui lòng nhập miêu tả ngắn',
            'body.required' => 'Vui lòng nhập nội dung bài viết'
        ];
    }
}
