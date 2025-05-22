<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhanQuyenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['id_phanquyen' => 1, 'tenquyen' => 'admin'],
            ['id_phanquyen' => 2, 'tenquyen' => 'user'],
        ];

        DB::table('phanquyen')->insert($roles);
    }
}