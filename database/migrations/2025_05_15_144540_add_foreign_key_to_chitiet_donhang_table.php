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
        Schema::table('chitiet_donhang', function (Blueprint $table) {
             $table->foreign('id_dathang')
                  ->references('id_dathang')
                  ->on('dathang')
                  ->onUpdate('restrict')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chitiet_donhang', function (Blueprint $table) {
             $table->dropForeign(['id_dathang']);
        });
    }
};
