<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Điện thoại (cateid: 1)
            [
                'productname' => 'iPhone 15 Pro Max 256GB',
                'price' => 34990000,
                'pricediscount' => 31990000,
                'cateid' => 1,
                'brandid' => 1, // Apple
                'image' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=600&auto=format&fit=crop',
                'description' => 'iPhone 15 Pro Max với thiết kế khung Titan cao cấp, chip A17 Pro siêu mạnh mẽ và camera zoom 5x.'
            ],
            [
                'productname' => 'Samsung Galaxy S24 Ultra 5G',
                'price' => 33990000,
                'pricediscount' => 29990000,
                'cateid' => 1,
                'brandid' => 2, // Samsung
                'image' => 'https://images.unsplash.com/photo-1610945265064-0e34e5519bbf?w=600&auto=format&fit=crop',
                'description' => 'Galaxy S24 Ultra với quyền năng Galaxy AI, camera 200MP và bút S-Pen thông minh.'
            ],
            [
                'productname' => 'Xiaomi 14 Ultra 512GB',
                'price' => 29990000,
                'pricediscount' => 26990000,
                'cateid' => 1,
                'brandid' => 3, // Xiaomi
                'image' => 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=600&auto=format&fit=crop',
                'description' => 'Xiaomi 14 Ultra hợp tác cùng Leica mang tới ống kính nhiếp ảnh di động đỉnh cao.'
            ],

            // Laptop (cateid: 2)
            [
                'productname' => 'MacBook Air M2 13 inch 8GB/256GB',
                'price' => 27990000,
                'pricediscount' => 24490000,
                'cateid' => 2,
                'brandid' => 1, // Apple
                'image' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=600&auto=format&fit=crop',
                'description' => 'MacBook Air M2 thiết kế siêu mỏng nhẹ, pin cực trâu lên đến 18 giờ liên tục.'
            ],
            [
                'productname' => 'Laptop Dell XPS 13 9315',
                'price' => 31990000,
                'pricediscount' => 28990000,
                'cateid' => 2,
                'brandid' => 5, // Dell
                'image' => 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=600&auto=format&fit=crop',
                'description' => 'Dell XPS 13 thiết kế viền màn hình siêu mỏng, vỏ nhôm nguyên khối sang trọng.'
            ],
            [
                'productname' => 'Asus ROG Strix G16 Gaming',
                'price' => 38990000,
                'pricediscount' => 35990000,
                'cateid' => 2,
                'brandid' => 4, // Asus
                'image' => 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=600&auto=format&fit=crop',
                'description' => 'Laptop Gaming Asus ROG Strix trang bị RTX 4060, màn hình 165Hz chuẩn Esports.'
            ],

            // Máy tính bảng (cateid: 3)
            [
                'productname' => 'iPad Air 5 M1 Wi-Fi 64GB',
                'price' => 14990000,
                'pricediscount' => 13490000,
                'cateid' => 3,
                'brandid' => 1, // Apple
                'image' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=600&auto=format&fit=crop',
                'description' => 'iPad Air 5 mang sức mạnh từ vi xử lý M1 vượt trội, màn hình Retina nét mịn.'
            ],
            [
                'productname' => 'Samsung Galaxy Tab S9 Ultra',
                'price' => 26990000,
                'pricediscount' => 23990000,
                'cateid' => 3,
                'brandid' => 2, // Samsung
                'image' => 'https://images.unsplash.com/photo-1561154464-82e9adf32764?w=600&auto=format&fit=crop',
                'description' => 'Máy tính bảng Galaxy Tab S9 Ultra màn hình Dynamic AMOLED 2X 14.6 inch cực lớn.'
            ],

            // Đồng hồ thông minh (cateid: 4)
            [
                'productname' => 'Apple Watch Series 9 GPS 41mm',
                'price' => 10490000,
                'pricediscount' => 9490000,
                'cateid' => 4,
                'brandid' => 1, // Apple
                'image' => 'https://images.unsplash.com/photo-1546868871-7041f2a55e12?w=600&auto=format&fit=crop',
                'description' => 'Apple Watch Series 9 hỗ trợ thao tác chạm hai lần (Double Tap) độc đáo.'
            ],
            [
                'productname' => 'Samsung Galaxy Watch6 Classic',
                'price' => 8990000,
                'pricediscount' => 7490000,
                'cateid' => 4,
                'brandid' => 2, // Samsung
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&auto=format&fit=crop',
                'description' => 'Galaxy Watch6 Classic với vòng xoay bezel vật lý truyền thống sang trọng.'
            ],

            // Tai nghe & Âm thanh (cateid: 5)
            [
                'productname' => 'Tai nghe Sony WH-1000XM5',
                'price' => 8490000,
                'pricediscount' => 7290000,
                'cateid' => 5,
                'brandid' => 8, // Sony
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&auto=format&fit=crop',
                'description' => 'Tai nghe chống ồn chủ động hàng đầu thế giới Sony WH-1000XM5 âm thanh Hi-Res.'
            ],
            [
                'productname' => 'AirPods Pro Gen 2 USB-C',
                'price' => 6190000,
                'pricediscount' => 5690000,
                'cateid' => 5,
                'brandid' => 1, // Apple
                'image' => 'https://images.unsplash.com/photo-1600294037681-c80b4cb5b434?w=600&auto=format&fit=crop',
                'description' => 'AirPods Pro 2 trang bị chip H2 chống ồn gấp 2 lần, cổng sạc USB-C mới.'
            ],

            // Phụ kiện (cateid: 6)
            [
                'productname' => 'Bàn phím cơ không dây Logitech MX Keys',
                'price' => 3290000,
                'pricediscount' => 2890000,
                'cateid' => 6,
                'brandid' => 3,
                'image' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=600&auto=format&fit=crop',
                'description' => 'Bàn phím cơ cao cấp gõ cực êm, kết nối thông minh 3 thiết bị cùng lúc.'
            ]
        ];

        foreach ($products as $idx => $p) {
            DB::table('products')->insert([
                'productname'   => $p['productname'],
                'slug'          => Str::slug($p['productname']),
                'price'         => $p['price'],
                'pricediscount' => $p['pricediscount'],
                'image'         => $p['image'],
                'description'   => $p['description'],
                'status'        => 1,
                'cateid'        => $p['cateid'],
                'brandid'       => $p['brandid'],
                'created_at'    => now(),
                'updated_at'    => now()
            ]);
        }
    }
}
