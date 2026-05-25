<?php

use Illuminate\Support\Facades\Route;

// Landing page
Route::get('/', function () {
    return view('landing.index');
});

// Painel Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn() => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
    Route::get('/matriculas', fn() => view('admin.matriculas'))->name('matriculas.index');
    Route::get('/treinos', fn() => view('admin.treinos'))->name('treinos.index');
    Route::get('/exercicios', fn() => view('admin.exercicios'))->name('exercicios.index');
    Route::get('/progresso', fn() => view('admin.progresso'))->name('progresso.index');
    Route::get('/planos', fn() => view('admin.planos'))->name('planos.index');
    Route::get('/frequencias', fn() => view('admin.frequencias'))->name('frequencias.index');
});
