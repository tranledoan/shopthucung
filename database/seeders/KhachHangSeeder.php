<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class KhachHangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Tạo tài khoản admin
        DB::table('khachhang')->insert([
            'hoten' => 'Chung Anh Hieu',
            'email' => 'chunganhhieu@gmail.com',
            'password' => Hash::make('123456'), // Mã hóa mật khẩu
            'diachi' => '52 Đường Vo Van Ngan, TP HCM',
            'sdt' => 1234567890,
            'id_phanquyen' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        for ($i = 0; $i < 99; $i++) {
            DB::table('khachhang')->insert([
                'hoten' => $i === 0 ? 'HieuAnh' : 'HieuAnh' . $i,
                'email' => $i === 0 ? 'hieuanh@gmail.com' : 'hieuanh' . $i . '@gmail.com',
                'password' => Hash::make('123456'),
                'diachi' => $faker->address,
                'sdt' => $faker->numberBetween(100000000, 999999999),
                'id_phanquyen' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}