<?php

namespace App\Http\Controllers;

use App\Models\Progresso;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProgressoController extends Controller
{
    public function index()
    {
        return Progresso::with('aluno')
            ->where('academia_id', $this->academiaId())
            ->latest('avaliado_em')
            ->latest('id')
            ->get();
    }

    public function show($id)
    {
        return $this->progressoDaAcademia()->findOrFail($id);
    }


    public function store(Request $request)
    {
        $data = $this->validateProgresso($request);
        $data['academia_id'] = $this->academiaId();
        $data['professor_id'] = auth()->id();

        $progresso = Progresso::create($data);

        return response()->json([
            'ok' => true,
            'progresso' => $progresso->load('aluno'),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $p = $this->progressoDaAcademia()->findOrFail($id);
        $p->update($this->validateProgresso($request));

        return $p->load('aluno');
    }

    public function destroy($id)
    {
        $this->progressoDaAcademia()->findOrFail($id)->delete();

        return response()->json(['message' => 'Removido']);
    }

    private function validateProgresso(Request $request): array
    {
        return $request->validate([
            'user_id' => [
                'required',
                Rule::exists('users', 'id')->where('academia_id', $this->academiaId()),
            ],
            'peso_kg' => 'nullable|numeric',
            'gordura_corporal_pct' => 'nullable|numeric',
            'massa_muscular_kg' => 'nullable|numeric',
            'observacoes' => 'nullable|string',
            'avaliado_em' => 'required|date',
        ]);
    }

    private function progressoDaAcademia()
    {
        return Progresso::with('aluno')
            ->where('academia_id', $this->academiaId());
    }
}
