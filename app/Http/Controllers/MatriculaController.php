<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MatriculaController extends Controller
{
    public function index()
    {
        return Matricula::with('user', 'plano')->get();
    }

    public function show($id)
    {
        return Matricula::with('user', 'plano')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'plano_id' => 'required|exists:planos,id',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'status' => 'required|string|max:255',
        ]);

        $nome = trim($data['nome']);
        $user = User::where('name', $nome)->first();

        if (!$user) {
            $user = User::create([
                'name' => $nome,
                'email' => Str::slug($nome).'-'.Str::lower(Str::random(8)).'@gym.local',
                'password' => bcrypt(Str::random(32)),
                'tipo' => 'aluno',
            ]);
        }

        $matricula = Matricula::create([
            'user_id' => $user->id,
            'plano_id' => $data['plano_id'],
            'data_inicio' => $data['data_inicio'],
            'data_fim' => $data['data_fim'],
            'status' => $data['status'],
        ]);

        return response()->json([
            'success' => true,
            'matricula' => $matricula->load('user', 'plano'),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'plano_id' => 'required|exists:planos,id',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'status' => 'required|string|max:255',
        ]);

        $matricula = Matricula::findOrFail($id);
        $matricula->update($data);
        $matricula->user->update(['name' => trim($data['nome'])]);

        return response()->json([
            'success' => true,
            'matricula' => $matricula->load('user', 'plano'),
        ]);
    }

    public function destroy($id)
    {
        Matricula::findOrFail($id)->delete();

        return response()->json(['success' => true]);
    }

    public function alunosMatriculados()
    {
        return Matricula::with('user:id,name')
            ->whereNotNull('user_id')
            ->get()
            ->map(fn ($matricula) => $matricula->user)
            ->filter()
            ->unique('id')
            ->values();
    }
}
