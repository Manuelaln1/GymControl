<?php

namespace App\Http\Controllers;

use App\Models\Progresso;
use Illuminate\Http\Request;

class ProgressoController extends Controller
{
    public function index()
    {
        return Progresso::with('aluno')->get();
    }

    public function show($id)
    {
        return Progresso::with('aluno')->findOrFail($id);
    }


public function store(Request $request)
{
    $data = $request->validate([
        'user_id' => 'required',
        'peso_kg' => 'nullable',
        'gordura_corporal_pct' => 'nullable',
        'massa_muscular_kg' => 'nullable',
        'observacoes' => 'nullable',
        'avaliado_em' => 'required|date',
    ]);

    $data['professor_id'] = 1;

    Progresso::create($data);

    return response()->json(['ok' => true]);
}

    public function update(Request $request, $id)
    {
        $p = Progresso::findOrFail($id);
        $p->update($request->all());

        return $p;
    }

    public function destroy($id)
    {
        Progresso::findOrFail($id)->delete();

        return response()->json(['message' => 'Removido']);
    }
}