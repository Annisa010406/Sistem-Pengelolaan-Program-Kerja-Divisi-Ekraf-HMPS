<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            // Primary key kustom report_id
            $table->id('report_id');

            // Foreign Key ke tabel programs via program_id kustom Anda
            $table->foreignId('program_id')->constrained('programs', 'program_id')->onDelete('cascade');

            // Sesuai field dari gambar ERD Anda
            $table->text('result');
            $table->timestamps(); // Ini otomatis mencakup datetime created_at dan updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
