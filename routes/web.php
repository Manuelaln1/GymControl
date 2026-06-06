<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrequenciaController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\PlanoController;
use App\Http\Controllers\ProgressoController;
use App\Http\Controllers\TreinoController;

// Landing page
Route::get('/', function () {
    return view('landing.index');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/registrar', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/registrar', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::prefix('api')->middleware('auth')->group(function () {
    Route::apiResource('planos', PlanoController::class);
    Route::apiResource('matriculas', MatriculaController::class);
    Route::get('/treinos/{id}/pdf', [TreinoController::class, 'pdf'])->name('treinos.pdf');
    Route::apiResource('treinos', TreinoController::class);
    Route::apiResource('progresso', ProgressoController::class);
    Route::apiResource('frequencias', FrequenciaController::class);
    Route::get('/alunos-matriculados', [MatriculaController::class, 'alunosMatriculados']);
});

// Painel Admin
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', fn() => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
    Route::get('/matriculas', fn() => view('admin.matriculas'))->name('matriculas.index');
    Route::get('/treinos', fn() => view('admin.treinos'))->name('treinos.index');
    Route::get('/progresso', fn() => view('admin.progresso'))->name('progresso.index');
    Route::get('/planos', fn() => view('admin.planos'))->name('planos.index');
    Route::get('/frequencias', fn() => view('admin.frequencias'))->name('frequencias.index');
});
