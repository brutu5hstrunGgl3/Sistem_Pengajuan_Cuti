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
        Schema::table('pengajuan_cuti', function (Blueprint $table) {
            Schema::table('pengajuan_cuti', function (Blueprint $table) {
                $table->unsignedBigInteger('id_pengguna')->nullable()->change(); // Mengubah id_pengguna menjadi nullable
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_cuti', function (Blueprint $table) {
            $table->unsignedBigInteger('id_pengguna')->nullable(false)->change();
        });
    }
};
