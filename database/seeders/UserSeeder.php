<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tài khoản Quản trị viên (Admin - Role 1)
        DB::table('users')->insert([
            'fullname'   => 'Trần Anh Kiệt (Admin)',
            'username'   => 'admin',
            'email'      => 'admin@gmail.com',
            'password'   => Hash::make('123456'),
            'phone'      => '0901234567',
            'address'    => 'TP. Hồ Chí Minh',
            'gender'     => 1,
            'birthday'   => '2000-01-01',
            'role'       => 1, // Admin
            'status'     => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // 2. Tài khoản Nhân viên (Staff - Role 2)
        DB::table('users')->insert([
            'fullname'   => 'Nguyễn Văn Nhân Viên',
            'username'   => 'nhanvien',
            'email'      => 'nhanvien@gmail.com',
            'password'   => Hash::make('123456'),
            'phone'      => '0987654321',
            'address'    => 'TP. Hồ Chí Minh',
            'gender'     => 1,
            'birthday'   => '2002-05-15',
            'role'       => 2, // Nhân viên
            'status'     => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // 3. Khách hàng mẫu
        $sampleUsers = [
            ['fullname' => 'Lê Thị Mai', 'email' => 'maile@gmail.com', 'phone' => '0912345678'],
            ['fullname' => 'Phạm Hoàng Nam', 'email' => 'nampham@gmail.com', 'phone' => '0934567890'],
            ['fullname' => 'Đỗ Minh Trí', 'email' => 'trido@gmail.com', 'phone' => '0978901234'],
        ];

        foreach ($sampleUsers as $idx => $u) {
            DB::table('users')->insert([
                'fullname'   => $u['fullname'],
                'username'   => 'user' . ($idx + 1),
                'email'      => $u['email'],
                'password'   => Hash::make('123456'),
                'phone'      => $u['phone'],
                'address'    => 'TP. Hồ Chí Minh',
                'gender'     => rand(0, 1),
                'birthday'   => '2001-08-20',
                'role'       => 2,
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
