<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DanhMucSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['id_danhmuc' => 1, 'ten_danhmuc' => 'Sản phẩm cho chó'],
            ['id_danhmuc' => 2, 'ten_danhmuc' => 'Sản phẩm cho mèo'],
            ['id_danhmuc' => 3, 'ten_danhmuc' => 'Tất cả sản phẩm'],
            ['id_danhmuc' => 4, 'ten_danhmuc' => 'Con giống'],
            ['id_danhmuc' => 5, 'ten_danhmuc' => 'Nổi bật'],
            ['id_danhmuc' => 6, 'ten_danhmuc' => 'Chó giống'],
            ['id_danhmuc' => 7, 'ten_danhmuc' => 'Mèo giống'],
        ];

        DB::table('danhmuc')->insert($categories);
    }
}