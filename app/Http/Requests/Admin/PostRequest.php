<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
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
        $id = $this->route('post');
        return [
            'title' => [
                'required',
                'min:5',
                'max:255',
                Rule::unique('posts', 'title')->ignore($id, 'id'),
            ],
            'slug' => [
                'required',
                'min:5',
                'max:255',
                'regex:/^[a-z0-9_-]+$/',
                Rule::unique('posts', 'slug')->ignore($id, 'id'),
            ],
            'content' => 'required|min:10',
            'status' => 'required|in:0,1',
            'user_id' => 'required|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống.',
            'min' => ':attribute phải từ :min ký tự trở lên.',
            'max' => ':attribute không vượt quá :max ký tự.',
            'unique' => ':attribute đã tồn tại.',
            'slug.regex' => ':attribute chỉ chứa chữ, số, dấu gạch dưới (_) và gạch ngang (-).',
            'exists' => ':attribute đã chọn không tồn tại.',
            'status.in' => ':attribute không hợp lệ.'
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'Tiêu đề bài viết',
            'slug' => 'Đường dẫn (Slug)',
            'content' => 'Nội dung bài viết',
            'status' => 'Trạng thái',
            'user_id' => 'Người đăng',
        ];
    }
}

