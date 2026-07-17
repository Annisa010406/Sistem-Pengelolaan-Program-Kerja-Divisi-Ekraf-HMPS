<?php

use Illuminate\Support\Facades\Route;
// 1. Tambahkan/Import Model-Model kamu di bagian atas ini
use App\Models\Division;
use App\Models\Program;
use App\Models\Agenda;
use App\Models\Documentation;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    // 2. GANTI LINE DASHBOARD LAMA DENGAN INI:
    Route::get('dashboard', function () {
        return view('dashboard', [
            'total_divisi' => Division::count(),
            'total_program' => Program::count(),
            'total_agenda' => Agenda::count(),
            'total_dokumentasi' => Documentation::count(),
            'recent_programs' => Program::latest()->take(5)->get(),
        ]);
    })->name('dashboard');

    // Route Livewire bawaan kamu tetap aman di bawah sini
    Route::livewire('/divisions', 'pages::division.index')
        ->name('division.index');
    Route::livewire('/programs', 'pages::program.index')
        ->name('program.index');
    Route::livewire('/agendas', 'pages::agenda.index')
        ->name('agenda.index');
    Route::livewire('/documentations', 'pages::documentation.index')
        ->name('documentation.index');
    Route::livewire('/reports', 'pages::report.index')
        ->name('report.index');
});

require __DIR__.'/settings.php';
