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
        Schema::create('riwayat_cuti', function (Blueprint $table) {
            $table->id(); // Kolom 'id' dengan auto_increment dan primary key
            $table->unsignedBigInteger('id_pengguna'); // Kolom 'id_pengguna' tanpa auto_increment
            $table->string('jenis_cuti');
            $table->timestamp('tanggal_pengajuan');
            $table->timestamp('tanggal_mulai');
            $table->timestamp('tanggal_selesai');
            $table->string('alasan');
            $table->string('status');
            $table->timestamps();
        
            // Jika 'id_pengguna' adalah foreign key yang mengacu ke tabel 'users'
            $table->foreign('id_pengguna')->references('id')->on('users')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_cuti');
    }
};
