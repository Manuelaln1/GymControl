<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Treino;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class TreinoController extends Controller
{
    // LISTAR TREINOS
    public function index()
    {
        return Treino::with('user')->get();
    }

    // MOSTRAR TREINO
    public function show($id)
    {
        return Treino::with('user')
            ->findOrFail($id);
    }

    // CRIAR TREINO
    public function store(Request $request)
    {
        try {

            if (!$request->user_id && !$request->aluno_nome) {
                return response()->json([
                    'success' => false,
                    'error' => 'Aluno não informado'
                ], 422);
            }

            $user = null;

            if ($request->user_id) {
                $user = User::find($request->user_id);
            }

            if (!$user) {

                $nome = $request->aluno_nome;

                $user = User::firstOrCreate(
                    ['name' => $nome],
                    [
                        'email' => Str::slug($nome) . rand(1000,9999) . '@gym.com',
                        'password' => bcrypt('123456'),
                        'tipo' => 'aluno'
                    ]
                );
            }

            $treino = Treino::create([
                'user_id' => $user->id,
                'nome' => $request->nome,
                'objetivo' => $request->objetivo,
                'observacoes' => $request->observacoes,
                'ativo' => $request->ativo ?? 1
            ]);

            return response()->json([
                'success' => true,
                'treino' => $treino->load('user')
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ATUALIZAR
    public function update(Request $request, $id)
    {
        $treino = Treino::findOrFail($id);

        $treino->update([
            'user_id' => $request->user_id,
            'nome' => $request->nome,
            'objetivo' => $request->objetivo,
            'observacoes' => $request->observacoes,
            'ativo' => $request->ativo
        ]);

        return response()->json([
            'success' => true,
            'treino' => $treino->load('user')
        ]);
    }

    // DELETAR
    public function destroy($id)
    {
        Treino::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Treino removido'
        ]);
    }

    // GERAR PDF
    public function pdf($id)
    {
        $treino = Treino::with('user')->findOrFail($id);

        $pdf = Pdf::loadView('pdf.treino', compact('treino'));

        return $pdf->download('treino-'.$treino->id.'.pdf');
    }
}