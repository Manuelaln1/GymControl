<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('treino_exercicios', function (Blueprint $table) {
            $table->id();

            $table->foreignId('treino_id')->constrained()->onDelete('cascade');
            $table->foreignId('exercicio_id')->constrained()->onDelete('cascade');

            $table->integer('series');
            $table->string('repeticoes');
            $table->decimal('carga_kg', 5, 1)->nullable();
            $table->integer('descanso_segundos')->nullable();
            $table->integer('ordem')->default(0);
            $table->string('observacoes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('treino_exercicios');
    }
};