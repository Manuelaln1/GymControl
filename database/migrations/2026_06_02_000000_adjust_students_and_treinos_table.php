<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'tipo')) {
                $table->string('tipo')->nullable()->after('password');
            }
        });

        Schema::table('treinos', function (Blueprint $table) {
            if (Schema::hasColumn('treinos', 'professor_id')) {
                $table->dropForeign(['professor_id']);
                $table->dropColumn('professor_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('treinos', function (Blueprint $table) {
            if (!Schema::hasColumn('treinos', 'professor_id')) {
                $table->foreignId('professor_id')->nullable()->constrained('users')->onDelete('cascade');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'tipo')) {
                $table->dropColumn('tipo');
            }
        });
    }
};
