<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
        $id = $this->route('product');
        return [
            'productname' => [
                'required',
                'min:5',
                'max:150',
                Rule::unique('products', 'productname')->ignore($id, 'id'),
            ],
            'slug' => [
                'required',
                'min:5',
                'max:255',
                'regex:/^[a-z0-9_-]+$/',
                Rule::unique('products', 'slug')->ignore($id, 'id'),
            ],
            'price' => 'required|numeric|min:0|max:10000000',
            'pricediscount' => 'nullable|numeric|min:0|lte:price',
            'status' => 'required|in:0,1',
            'cateid' => 'required|exists:categories,cateid',
            'brandid' => 'required|exists:brands,id',
            'description' => [
                'nullable',
                'string',
                'regex:/^[^@!\$\^]*$/'
            ],
            'img' => [
                $id ? 'nullable' : 'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:200',
            ],
            'imgs' => [
                'nullable',
                'array',
            ],
            'imgs.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:200',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống.',
            'min' => ':attribute phải từ :min ký tự trở lên.',
            'max' => ':attribute không vượt quá :max ký tự.',
            'unique' => ':attribute đã tồn tại.',
            'numeric' => ':attribute phải là số.',
            'price.max' => ':attribute phải nhỏ hơn 10.000.000.',
            'pricediscount.lte' => ':attribute phải nhỏ hơn hoặc bằng đơn giá.',
            'status.in' => ':attribute không hợp lệ.',
            'exists' => ':attribute đã chọn không tồn tại.',
            'slug.regex' => ':attribute chỉ chứa chữ, số, dấu gạch dưới (_) và gạch ngang (-).',
            'description.regex' => ':attribute không được chứa các ký tự đặc biệt như @, !, $, ^.',
            'img.required' => ':attribute không được để trống.',
            'img.image' => ':attribute phải là hình ảnh.',
            'img.mimes' => ':attribute chỉ chấp nhận các định dạng: jpg, jpeg, png, webp.',
            'img.max' => ':attribute không được vượt quá 200 KB.',
            'imgs.*.image' => 'Ảnh phụ phải là hình ảnh.',
            'imgs.*.mimes' => 'Ảnh phụ chỉ chấp nhận các định dạng: jpg, jpeg, png, webp.',
            'imgs.*.max' => 'Ảnh phụ không được vượt quá 200 KB.',
        ];
    }

    public function attributes(): array
    {
        return [
            'productname' => 'Tên sản phẩm',
            'slug' => 'Đường dẫn (Slug)',
            'price' => 'Đơn giá',
            'pricediscount' => 'Giá khuyến mãi',
            'status' => 'Trạng thái',
            'cateid' => 'Loại sản phẩm',
            'brandid' => 'Thương hiệu',
            'description' => 'Mô tả sản phẩm',
            'img' => 'Hình ảnh chính',
            'imgs' => 'Hình ảnh phụ',
        ];
    }
}

