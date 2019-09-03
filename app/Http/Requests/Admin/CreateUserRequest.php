<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'password' => 'required|min:6|max:20',
            'password_confirmation' => 'required|same:password',
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
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Vui lòng nhập nhiều hơn 6 ký tự',
            'password.max' => 'Vui lòng không nhập không quá 20 ký tự',
            'password_confirmation.required' => 'Vui lòng không bỏ trống',
            'password_confirmation.same' => 'Mật khẩu nhập lại không trùng khớp',
            'full_name.required' => 'Vui lòng không bỏ trống họ và tên',
            'full_name.max' => 'Vui lòng không nhập quá 191 ký tự',
            'phone.numeric' => 'Vui lòng chỉ nhập số',
            'phone.digits_between' => 'Vui lòng không nhập quá 15 số',
            'address.max' => 'Vui lòng không nhập quá 191 ký tự'
        ];
    }
}
