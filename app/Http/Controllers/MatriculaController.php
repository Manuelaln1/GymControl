<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MatriculaController extends Controller
{
    // LISTAR MATRÍCULAS
    public function index()
    {
        return Matricula::with('user', 'plano')->get();
    }

    // MOSTRAR MATRÍCULA
    public function show($id)
    {
        return Matricula::with('user', 'plano')->findOrFail($id);
    }

    // CRIAR MATRÍCULA + CRIAR ALUNO SE NÃO EXISTIR
   public function store(Request $request)
{
    try {

        if ($request->user_id) {

        $user = User::find($request->user_id);

    } else {

        $user = User::create([
            'name' => $request->nome,
            'email' => Str::slug($request->nome) . rand(1000,9999) . '@gym.com',
            'password' => bcrypt('123456'),
            'tipo' => 'aluno'
        ]);
    }

        $matricula = Matricula::create([
            'user_id' => $user->id,
            'plano_id' => $request->plano_id,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'matricula' => $matricula
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
}
    // ATUALIZAR
   public function update(Request $request, $id)
{
    $matricula = Matricula::findOrFail($id);

    $matricula->update([
        'plano_id' => $request->plano_id,
        'data_inicio' => $request->data_inicio,
        'data_fim' => $request->data_fim,
        'status' => $request->status
    ]);

    // Atualiza o nome do aluno
    if ($matricula->user && $request->nome) {
        $matricula->user->update([
            'name' => $request->nome
        ]);
    }

    return response()->json([
        'success' => true,
        'matricula' => $matricula->load('user', 'plano')
    ]);
}

    // DELETAR
    public function destroy($id)
    {
        Matricula::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Matrícula removida'
        ]);
    }

    // LISTAR ALUNOS
    public function alunosMatriculados()
    {
        return Matricula::with('user')
            ->whereNotNull('user_id')
            ->get()
            ->map(fn($m) => $m->user)
            ->filter()
            ->unique('id')
            ->values();
    }
}