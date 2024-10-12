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
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // ID session
            $table->text('payload'); // Data sesi
            $table->integer('last_activity'); // Timestamp aktivitas terakhir
            $table->string('user_id')->nullable(); // ID pengguna, jika diperlukan
            $table->string('ip_address')->nullable(); // Alamat IP, jika diperlukan
            $table->string('user_agent')->nullable(); // User agent, jika diperlukan
            $table->timestamps(); // Created at dan updated at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
