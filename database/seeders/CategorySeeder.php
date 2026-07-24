<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['catename' => 'Điện thoại', 'description' => 'Các dòng điện thoại thông minh chính hãng mới nhất'],
            ['catename' => 'Laptop', 'description' => 'Máy tính xách tay văn phòng, đồ họa và gaming'],
            ['catename' => 'Máy tính bảng', 'description' => 'Tablet phục vụ học tập, làm việc và giải trí'],
            ['catename' => 'Đồng hồ thông minh', 'description' => 'Smartwatch theo dõi sức khỏe và thể thao'],
            ['catename' => 'Tai nghe & Âm thanh', 'description' => 'Tai nghe Bluetooth, loa máy tính chính hãng'],
            ['catename' => 'Phụ kiện công nghệ', 'description' => 'Sạc dự phòng, cáp sạc, ốp lưng, bàn phím, chuột'],
        ];

        foreach ($categories as $index => $cat) {
            DB::table('categories')->insert([
                'catename'    => $cat['catename'],
                'slug'        => Str::slug($cat['catename']),
                'status'      => 1,
                'sort_order'  => $index + 1,
                'description' => $cat['description'],
                'created_at'  => now(),
                'updated_at'  => now()
            ]);
        }
    }
}
