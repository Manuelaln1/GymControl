<?php

namespace App\Http\Controllers;

use App\Models\Plano;
use Illuminate\Http\Request;


class PlanoController extends Controller
{
    // LISTAR TODOS OS PLANOS
    public function index()
    {
        return response()->json(
            Plano::where('academia_id', $this->academiaId())->get()
        );
    }

    // MOSTRAR UM PLANO
    public function show($id)
    {
        return response()->json($this->findPlano($id));
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
            'academia_id' => $this->academiaId(),
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
        $plano = $this->findPlano($id);

        $plano->update($request->validate([
            'nome' => 'sometimes|required|string',
            'preco' => 'sometimes|required|numeric',
            'duracao_dias' => 'sometimes|required|integer',
            'ativo' => 'sometimes|boolean',
        ]));

        return response()->json($plano);
    }

    // DELETAR PLANO
    public function destroy($id)
    {
        $plano = $this->findPlano($id);
        $plano->delete();

        return response()->json([
            'message' => 'Plano removido com sucesso'
        ]);
    }

    private function findPlano($id): Plano
    {
        return Plano::where('academia_id', $this->academiaId())->findOrFail($id);
    }
}
