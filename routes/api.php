<?php

use App\Http\Controllers\PlanoController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\ExercicioController;
use App\Http\Controllers\TreinoController;
use App\Http\Controllers\TreinoExercicioController;
use App\Http\Controllers\ProgressoController;
use App\Http\Controllers\FrequenciaController;

Route::apiResource('planos', PlanoController::class);
Route::apiResource('matriculas', MatriculaController::class);
Route::apiResource('exercicios', ExercicioController::class);
Route::apiResource('treinos', TreinoController::class);
Route::apiResource('treino-exercicios', TreinoExercicioController::class);
Route::apiResource('progresso', ProgressoController::class);
Route::apiResource('frequencias', FrequenciaController::class);