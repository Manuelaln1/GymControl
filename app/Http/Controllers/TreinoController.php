<?php

namespace App\Http\Controllers;

use App\Models\Treino;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TreinoController extends Controller
{
    public function index()
    {
        return Treino::with('user')
            ->where('academia_id', $this->academiaId())
            ->get();
    }

    public function show($id)
    {
        return $this->treinosDaAcademia()->findOrFail($id);
    }

    public function store(Request $request)
    {
        $treino = Treino::create([
            'academia_id' => $this->academiaId(),
            ...$this->validateTreino($request),
        ]);

        return response()->json([
            'success' => true,
            'treino' => $treino->load('user'),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $treino = $this->treinosDaAcademia()->findOrFail($id);
        $treino->update($this->validateTreino($request));

        return response()->json([
            'success' => true,
            'treino' => $treino->load('user'),
        ]);
    }

    public function destroy($id)
    {
        $this->treinosDaAcademia()->findOrFail($id)->delete();

        return response()->json(['success' => true]);
    }

    public function pdf($id)
    {
        $treino = $this->treinosDaAcademia()->findOrFail($id);
        $pdf = Pdf::loadView('pdf.treino', compact('treino'))->setPaper('a4');
        $arquivo = 'treino-'.Str::slug($treino->nome).'-'.$treino->id.'.pdf';

        return $pdf->download($arquivo);
    }

    private function validateTreino(Request $request): array
    {
        return $request->validate([
            'user_id' => [
                'required',
                Rule::exists('users', 'id')->where('academia_id', $this->academiaId()),
            ],
            'nome' => 'required|string|max:255',
            'objetivo' => 'required|string|max:255',
            'observacoes' => 'nullable|string',
            'ativo' => 'required|boolean',
        ]);
    }

    private function treinosDaAcademia()
    {
        return Treino::with('user')
            ->where('academia_id', $this->academiaId());
    }
}
