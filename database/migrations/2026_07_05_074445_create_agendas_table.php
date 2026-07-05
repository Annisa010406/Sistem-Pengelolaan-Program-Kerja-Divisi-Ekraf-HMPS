<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agendas', function (Blueprint $table) {
            // Primary key kustom agenda_id
            $table->id('agenda_id');

            // Foreign Key menghubungkan ke programs via program_id kustom Anda
            $table->foreignId('program_id')->constrained('programs', 'program_id')->onDelete('cascade');

            // Sesuai field di ERD gambar
            $table->string('agenda_name');
            $table->dateTime('agenda_date');
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
