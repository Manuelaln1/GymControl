<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academias', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('telefone', 30)->nullable();
            $table->string('endereco')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academias');
    }
};
