<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documentations', function (Blueprint $table) {
            // Primary key kustom documentation_id
            $table->id('documentation_id');

            // Foreign Key ke tabel programs via program_id
            $table->foreignId('program_id')->constrained('programs', 'program_id')->onDelete('cascade');

            // Sesuai field di ERD gambar
            $table->string('file_path');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documentations');
    }
};
