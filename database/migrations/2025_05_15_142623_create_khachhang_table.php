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
        Schema::create('khachhang', function (Blueprint $table) {
            $table->integer('id_kh', true);
            $table->string('hoten', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('password', 100)->nullable();
            $table->string('diachi')->nullable();
            $table->integer('sdt')->nullable();
            $table->integer('id_phanquyen')->index('fk_dk');
            $table->boolean('is_superadmin')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khachhang');
    }
};
