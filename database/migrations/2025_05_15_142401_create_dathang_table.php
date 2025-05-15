<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dathang', function (Blueprint $table) {
            $table->increments('id_dathang'); 
            $table->dateTime('ngaydathang')->nullable()->useCurrent();
            $table->dateTime('ngaygiaohang')->nullable()->useCurrent();
            $table->integer('tongtien');
            $table->string('phuongthucthanhtoan', 10);
            $table->string('diachigiaohang', 100)->nullable();
            $table->string('trangthai', 100)->nullable();
            $table->integer('id_kh');
            $table->index('id_dathang'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dathang');
    }
};
