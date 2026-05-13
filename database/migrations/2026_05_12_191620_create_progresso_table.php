<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('progresso', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('professor_id')->constrained('users')->onDelete('cascade');

            $table->decimal('peso_kg', 5, 2)->nullable();
            $table->decimal('gordura_corporal_pct', 4, 2)->nullable();
            $table->decimal('massa_muscular_kg', 5, 2)->nullable();

            $table->text('observacoes')->nullable();
            $table->date('avaliado_em');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('progresso');
    }
};
