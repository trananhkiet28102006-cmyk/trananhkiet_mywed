<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            ['brandname' => 'Apple', 'description' => 'Thương hiệu công nghệ hàng đầu thế giới từ Mỹ'],
            ['brandname' => 'Samsung', 'description' => 'Tập đoàn công nghệ điện tử hàng đầu Hàn Quốc'],
            ['brandname' => 'Xiaomi', 'description' => 'Thương hiệu thiết bị thông minh giá rẻ chất lượng'],
            ['brandname' => 'Asus', 'description' => 'Thương hiệu máy tính, laptop gaming nổi tiếng'],
            ['brandname' => 'Dell', 'description' => 'Thương hiệu laptop bền bỉ hàng đầu cho doanh nghiệp'],
            ['brandname' => 'HP', 'description' => 'Máy tính xách tay và thiết bị văn phòng tin cậy'],
            ['brandname' => 'Lenovo', 'description' => 'Thương hiệu laptop ThinkPad và Yoga cao cấp'],
            ['brandname' => 'Sony', 'description' => 'Hãng sản xuất tai nghe và âm thanh hàng đầu thế giới'],
        ];

        foreach ($brands as $index => $b) {
            DB::table('brands')->insert([
                'brandname'   => $b['brandname'],
                'slug'        => Str::slug($b['brandname']),
                'status'      => 1,
                'sort_order'  => $index + 1,
                'description' => $b['description'],
                'created_at'  => now(),
                'updated_at'  => now()
            ]);
        }
    }
}
