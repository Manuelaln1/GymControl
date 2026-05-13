<?php

namespace App\Http\Controllers;

use App\Models\Treino;
use Illuminate\Http\Request;

class TreinoController extends Controller
{
    // LISTAR TREINOS
    public function index()
    {
        return Treino::with(
            'aluno',
            'professor',
            'treinoExercicios'
        )->get();
    }

    // MOSTRAR TREINO
    public function show($id)
    {
        return Treino::with(
            'aluno',
            'professor',
            'treinoExercicios'
        )->findOrFail($id);
    }

    // CRIAR TREINO
    public function store(Request $request)
    {
        $treino = Treino::create([
            'user_id' => $request->user_id,
            'professor_id' => $request->professor_id,
            'nome' => $request->nome,
            'objetivo' => $request->objetivo,
            'observacoes' => $request->observacoes,
            'pdf_caminho' => $request->pdf_caminho,
            'ativo' => $request->ativo
        ]);

        return response()->json($treino, 201);
    }

    // ATUALIZAR TREINO
    public function update(Request $request, $id)
    {
        $treino = Treino::findOrFail($id);

        $treino->update($request->all());

        return response()->json($treino);
    }

    // DELETAR TREINO
    public function destroy($id)
    {
        Treino::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Treino removido'
        ]);
    }
}