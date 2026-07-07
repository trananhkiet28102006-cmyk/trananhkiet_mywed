<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Thêm tài khoản admin cố định
        DB::table('users')->insert([
            'fullname' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '0123456789',
            'address' => 'Hải Phòng, Việt Nam',
            'gender' => 1,
            'birthday' => '2000-01-01',
            'role' => 1,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        for ($i = 1; $i <= 10; $i++) {
            DB::table('users')->insert([
                'fullname' => fake()->name(),
                'username' => fake()->unique()->userName(),
                'email' => fake()->unique()->safeEmail(),
                'password' => Hash::make('password'),
                'phone' => fake()->unique()->phoneNumber(),
                'address' => fake()->address(),
                'gender' => fake()->numberBetween(0, 2),
                'birthday' => fake()->date(),
                'role' => fake()->numberBetween(1, 2),
                'status' => fake()->numberBetween(0, 1),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
