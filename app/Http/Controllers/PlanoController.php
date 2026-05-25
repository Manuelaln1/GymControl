<?php

namespace App\Http\Controllers;

use App\Models\Plano;
use Illuminate\Http\Request;

class PlanoController extends Controller
{
    // LISTAR TODOS OS PLANOS
    public function index()
    {
        return response()->json(Plano::all());
    }

    // MOSTRAR UM PLANO
    public function show($id)
    {
        return response()->json(Plano::findOrFail($id));
    }

    // CRIAR PLANO
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'preco' => 'required|numeric',
            'duracao_dias' => 'required|integer',
            'ativo' => 'boolean'
        ]);

        $plano = Plano::create([
            'nome' => $request->nome,
            'preco' => $request->preco,
            'duracao_dias' => $request->duracao_dias,
            'ativo' => $request->ativo ?? true
        ]);

        return response()->json($plano, 201);
    }

    // ATUALIZAR PLANO
    public function update(Request $request, $id)
    {
        $plano = Plano::findOrFail($id);

        $plano->update($request->only([
            'nome',
            'preco',
            'duracao_dias',
            'ativo'
        ]));

        return response()->json($plano);
    }

    // DELETAR PLANO
    public function destroy($id)
    {
        $plano = Plano::findOrFail($id);
        $plano->delete();

        return response()->json([
            'message' => 'Plano removido com sucesso'
        ]);
    }
}