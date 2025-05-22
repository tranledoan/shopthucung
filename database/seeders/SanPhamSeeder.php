<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SanPhamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Chèn 6 bản ghi từ câu lệnh SQL
        $fixedProducts = [
            [
                'id_sanpham' => 1,
                'tensp' => 'Thức Ăn Cho Chó Trưởng Thành Giống Lớn – Eminent Adult Large Breed – 500g',
                'anhsp' => 'frontend/upload/Eminent.jpg',
                'giasp' => 72000,
                'mota' => 'abc',
                'giamgia' => 0,
                'giakhuyenmai' => 72000,
                'soluong' => 2,
                'id_danhmuc' => 1,
            ],
            [
                'id_sanpham' => 2,
                'tensp' => 'Pate Cho Mèo – Pate Fit4 Cats - Cá Ngừ Và Thanh Cua 160g',
                'anhsp' => 'frontend/upload/dohop.jpg',
                'giasp' => 20000,
                'mota' => null,
                'giamgia' => 0,
                'giakhuyenmai' => 72000,
                'soluong' => 5,
                'id_danhmuc' => 2,
            ],
            [
                'id_sanpham' => 3,
                'tensp' => 'Chó Bull',
                'anhsp' => 'frontend/upload/Chó-Bully.jpg',
                'giasp' => 72000,
                'mota' => null,
                'giamgia' => 0,
                'giakhuyenmai' => 72000,
                'soluong' => 5,
                'id_danhmuc' => 6,
            ],
            [
                'id_sanpham' => 4,
                'tensp' => 'Cheems',
                'anhsp' => 'frontend/upload/meme-cheems-1.png',
                'giasp' => 20000,
                'mota' => null,
                'giamgia' => 0,
                'giakhuyenmai' => 72000,
                'soluong' => 2,
                'id_danhmuc' => 7,
            ],
            [
                'id_sanpham' => 5,
                'tensp' => 'Chó chihuahua',
                'anhsp' => 'frontend/upload/Chó-chi-hua-hua.jpg',
                'giasp' => 20000,
                'mota' => null,
                'giamgia' => 0,
                'giakhuyenmai' => 20000,
                'soluong' => 3,
                'id_danhmuc' => 6,
            ],
            [
                'id_sanpham' => 6,
                'tensp' => 'Bánh Gặm Cho Chó – Smoked Beefy Dental Bone -14g',
                'anhsp' => 'frontend/upload/dochocho.jpg',
                'giasp' => 20000,
                'mota' => null,
                'giamgia' => 0,
                'giakhuyenmai' => 20000,
                'soluong' => 6,
                'id_danhmuc' => 1,
            ],
        ];
  

        DB::table('sanpham')->insert($fixedProducts);

        // Tạo 94 sản phẩm ngẫu nhiên
        for ($i = 7; $i <= 100; $i++) {
            $giasp = $faker->numberBetween(10000, 100000);
            $giamgia = $faker->numberBetween(0, 50); 
            $giakhuyenmai = $giasp - ($giasp * $giamgia / 100);

            DB::table('sanpham')->insert([
                'id_sanpham' => $i,
                'tensp' => 'Giong Thu Cung', 
                'anhsp' => 'frontend/upload/anh' . $i . '.jpg', 
                'giasp' => $giasp,
                'mota' => null, 
                'giamgia' => $giamgia,
                'giakhuyenmai' => $giakhuyenmai,
                'soluong' => $faker->numberBetween(1, 100),
                'id_danhmuc' => $faker->numberBetween(1, 7), 
            ]);
        }
    }
}