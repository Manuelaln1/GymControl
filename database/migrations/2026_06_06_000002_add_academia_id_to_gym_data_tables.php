<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['planos', 'matriculas', 'treinos', 'progresso', 'frequencias'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (!Schema::hasColumn($tableName, 'academia_id')) {
                    $table->foreignId('academia_id')
                        ->nullable()
                        ->after('id')
                        ->constrained('academias')
                        ->nullOnDelete();
                }
            });
        }

        $this->backfillAcademiaIds();
    }

    public function down(): void
    {
        foreach (['frequencias', 'progresso', 'treinos', 'matriculas', 'planos'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (Schema::hasColumn($tableName, 'academia_id')) {
                    $table->dropConstrainedForeignId('academia_id');
                }
            });
        }
    }

    private function backfillAcademiaIds(): void
    {
        foreach (['matriculas', 'treinos', 'frequencias'] as $tableName) {
            DB::table($tableName)
                ->join('users', "{$tableName}.user_id", '=', 'users.id')
                ->whereNull("{$tableName}.academia_id")
                ->whereNotNull('users.academia_id')
                ->update(["{$tableName}.academia_id" => DB::raw('users.academia_id')]);
        }

        DB::table('progresso')
            ->join('users', 'progresso.user_id', '=', 'users.id')
            ->whereNull('progresso.academia_id')
            ->whereNotNull('users.academia_id')
            ->update(['progresso.academia_id' => DB::raw('users.academia_id')]);

        DB::table('planos')
            ->whereNull('academia_id')
            ->orderBy('id')
            ->get('id')
            ->each(function ($plano) {
                $academiaId = DB::table('matriculas')
                    ->join('users', 'matriculas.user_id', '=', 'users.id')
                    ->where('matriculas.plano_id', $plano->id)
                    ->whereNotNull('users.academia_id')
                    ->value('users.academia_id');

                if ($academiaId) {
                    DB::table('planos')
                        ->where('id', $plano->id)
                        ->update(['academia_id' => $academiaId]);
                }
            });
    }
};
