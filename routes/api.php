<?php


use App\Http\Controllers\PlanoController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\TreinoController;
use App\Http\Controllers\ProgressoController;
use App\Http\Controllers\FrequenciaController;
use Illuminate\Support\Facades\Route;

Route::apiResource('planos', PlanoController::class);
Route::apiResource('matriculas', MatriculaController::class);
Route::get('/treinos/{id}/pdf', [TreinoController::class, 'pdf'])->name('treinos.pdf');
Route::apiResource('treinos', TreinoController::class);
Route::apiResource('progresso', ProgressoController::class);
Route::apiResource('frequencias', FrequenciaController::class);
Route::get('/alunos-matriculados', [MatriculaController::class, 'alunosMatriculados']);
