<?php

namespace App\Http\Controllers;

use App\Models\Treino;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TreinoController extends Controller
{
    public function index()
    {
        return Treino::with('user')->get();
    }

    public function show($id)
    {
        return Treino::with('user')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $treino = Treino::create($this->validateTreino($request));

        return response()->json([
            'success' => true,
            'treino' => $treino->load('user'),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $treino = Treino::findOrFail($id);
        $treino->update($this->validateTreino($request));

        return response()->json([
            'success' => true,
            'treino' => $treino->load('user'),
        ]);
    }

    public function destroy($id)
    {
        Treino::findOrFail($id)->delete();

        return response()->json(['success' => true]);
    }

    public function pdf($id)
    {
        $treino = Treino::with('user')->findOrFail($id);
        $pdf = Pdf::loadView('pdf.treino', compact('treino'))->setPaper('a4');
        $arquivo = 'treino-'.Str::slug($treino->nome).'-'.$treino->id.'.pdf';

        return $pdf->download($arquivo);
    }

    private function validateTreino(Request $request): array
    {
        return $request->validate([
            'user_id' => 'required|exists:users,id',
            'nome' => 'required|string|max:255',
            'objetivo' => 'required|string|max:255',
            'observacoes' => 'nullable|string',
            'ativo' => 'required|boolean',
        ]);
    }
}
