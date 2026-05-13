<?php

namespace App\Http\Controllers;

use App\Models\Exercicio;
use Illuminate\Http\Request;

class ExercicioController extends Controller
{
    // LISTAR EXERCÍCIOS
    public function index()
    {
        return Exercicio::all();
    }

    // MOSTRAR EXERCÍCIO
    public function show($id)
    {
        return Exercicio::findOrFail($id);
    }

    // CRIAR EXERCÍCIO
    public function store(Request $request)
    {
        $exercicio = Exercicio::create([
            'nome' => $request->nome,
            'grupo_muscular' => $request->grupo_muscular,
            'descricao' => $request->descricao,
            'equipamento' => $request->equipamento
        ]);

        return response()->json($exercicio, 201);
    }

    // ATUALIZAR EXERCÍCIO
    public function update(Request $request, $id)
    {
        $exercicio = Exercicio::findOrFail($id);

        $exercicio->update($request->all());

        return response()->json($exercicio);
    }

    // DELETAR EXERCÍCIO
    public function destroy($id)
    {
        Exercicio::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Exercício removido'
        ]);
    }
}