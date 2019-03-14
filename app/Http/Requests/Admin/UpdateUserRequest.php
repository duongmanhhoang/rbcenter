<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'avatar' => 'nullable|mimes:jpg,png,jpeg|max:2000',
            'username' => 'required|max:20',
            'email' => 'required|email|max:191',
            'full_name' => 'required|max:191',
            'phone' => 'nullable|numeric|digits_between:0,15',
            'address' => 'nullable|max:191'
        ];
    }

    public function messages()
    {
        return [
            'avatar.mimes' => 'Chỉ chấp nhận file định dạng jpg, png, jpeg',
            'avatar.max' => 'File tải lên không được vượt quá 2MB',
            'username.required' => 'Vui lòng điền tên đăng nhập',
            'username.max:20' => 'Vui lòng nhập quá 20 ký tự',
            'email.required' => 'Vui lòng không bỏ trống email',
            'email.email' => 'Vui lòng nhập đúng định dạng email',
            'full_name.required' => 'Vui lòng không bỏ trống họ và tên',
            'full_name.max' => 'Vui lòng không nhập quá 191 ký tự',
            'phone.numeric' => 'Vui lòng chỉ nhập số',
            'phone.digits_between' => 'Vui lòng không nhập quá 15 số',
            'address.max' => 'Vui lòng không nhập quá 191 ký tự'
        ];
    }
}
