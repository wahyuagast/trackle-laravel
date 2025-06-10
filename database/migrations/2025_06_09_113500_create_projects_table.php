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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->date('deadline_date');
            $table->foreignId('pic_user_id')->constrained('users')->onDelete('cascade');
            $table->enum('priority', ['Tinggi', 'Sedang', 'Rendah'])->default('Sedang');
            $table->enum('status', ['Belum Dimulai', 'Sedang Berjalan', 'Selesai', 'Ditunda', 'Dibatalkan'])->default('Belum Dimulai');
            $table->timestamps(); // otomatis membuat kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
