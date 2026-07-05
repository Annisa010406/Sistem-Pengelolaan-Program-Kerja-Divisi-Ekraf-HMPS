<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
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
