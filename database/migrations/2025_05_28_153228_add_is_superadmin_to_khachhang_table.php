<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsSuperadminToKhachhangTable extends Migration
{
    // public function up()
    // {
    //     Schema::table('khachhang', function (Blueprint $table) {
    //         $table->boolean('is_superadmin')->default(false);
    //     });
    // }

    public function down()
    {
        Schema::table('khachhang', function (Blueprint $table) {
            $table->dropColumn('is_superadmin');
        });
    }
}
