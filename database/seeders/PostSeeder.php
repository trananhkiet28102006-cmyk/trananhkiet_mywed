<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Đánh giá chi tiết iPhone 15 Pro Max: Khung Titan có thực sự vượt trội?',
                'content' => 'iPhone 15 Pro Max năm nay mang đến bước chuyển mình lớn với chất liệu Titan siêu nhẹ, nút Action Button tiện lợi và cụm camera zoom 5x ấn tượng...'
            ],
            [
                'title' => 'Top 5 Laptop sinh viên đáng mua nhất năm 2026 dưới 20 triệu',
                'content' => 'Lựa chọn laptop phù hợp cho sinh viên ngành CNTT, Kinh tế và Thiết kế đồ họa với ngân sách tiết kiệm nhất...'
            ],
            [
                'title' => 'Hướng dẫn cách bảo quản và sạc pin điện thoại đúng cách chống chai pin',
                'content' => 'Tìm hiểu các quy tắc vàng giúp kéo dài tuổi thọ viên pin điện thoại iPhone và Samsung của bạn hiệu quả nhất...'
            ],
            [
                'title' => 'So sánh Samsung Galaxy S24 Ultra và iPhone 15 Pro Max: Đâu là vua flagship?',
                'content' => 'Cùng đặt lên bàn cân hai chiếc điện thoại cao cấp nhất hiện nay để tìm ra lựa chọn hoàn hảo nhất cho nhu cầu của bạn...'
            ]
        ];

        foreach ($posts as $idx => $post) {
            DB::table('posts')->insert([
                'title'      => $post['title'],
                'slug'       => Str::slug($post['title']),
                'content'    => $post['content'],
                'image'      => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=600&auto=format&fit=crop',
                'status'     => 1,
                'user_id'    => 1, // Admin
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
