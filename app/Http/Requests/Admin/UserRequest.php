<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $id = $this->route('user');
        return [
            'fullname' => 'required|min:3|max:100',
            'username' => [
                'required',
                'min:3',
                'max:50',
                'regex:/^[a-zA-Z0-9_.]+$/',
                Rule::unique('users', 'username')->ignore($id, 'id'),
            ],
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('users', 'email')->ignore($id, 'id'),
            ],
            'password' => $this->isMethod('post') ? 'required|min:6' : 'nullable|min:6',
            'phone' => 'nullable|regex:/^[0-9]{10,11}$/',
            'address' => 'nullable|string|max:255',
            'role' => 'required|in:1,2',
            'status' => 'required|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống.',
            'min' => ':attribute phải từ :min ký tự trở lên.',
            'max' => ':attribute không vượt quá :max ký tự.',
            'unique' => ':attribute đã tồn tại.',
            'email' => ':attribute không đúng định dạng email.',
            'phone.regex' => ':attribute phải gồm 10 hoặc 11 chữ số.',
            'username.regex' => ':attribute chỉ gồm chữ, số, dấu gạch dưới và dấu chấm.',
            'role.in' => ':attribute không hợp lệ.',
            'status.in' => ':attribute không hợp lệ.'
        ];
    }

    public function attributes(): array
    {
        return [
            'fullname' => 'Họ và tên',
            'username' => 'Tên đăng nhập',
            'email' => 'Địa chỉ Email',
            'password' => 'Mật khẩu',
            'phone' => 'Số điện thoại',
            'address' => 'Địa chỉ',
            'role' => 'Vai trò hệ thống',
            'status' => 'Trạng thái'
        ];
    }
}

