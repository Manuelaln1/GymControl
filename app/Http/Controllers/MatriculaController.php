<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use Illuminate\Http\Request;

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
        return Matricula::with('user', 'plano')
            ->findOrFail($id);
    }

    // CRIAR MATRÍCULA
    public function store(Request $request)
    {
        $matricula = Matricula::create([
            'user_id' => $request->user_id,
            'plano_id' => $request->plano_id,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'status' => $request->status
        ]);

        return response()->json($matricula, 201);
    }

    // ATUALIZAR MATRÍCULA
    public function update(Request $request, $id)
    {
        $matricula = Matricula::findOrFail($id);

        $matricula->update($request->all());

        return response()->json($matricula);
    }

    // DELETAR MATRÍCULA
    public function destroy($id)
    {
        Matricula::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Matrícula removida'
        ]);
    }
}