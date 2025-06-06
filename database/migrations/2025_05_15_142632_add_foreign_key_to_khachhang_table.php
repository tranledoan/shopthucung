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
        Schema::table('khachhang', function (Blueprint $table) {
            $table->foreign(['id_phanquyen'], 'fk_dk')->references(['id_phanquyen'])->on('phanquyen')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('khachhang', function (Blueprint $table) {
            $table->dropForeign('fk_dk');
        });
    }
};
