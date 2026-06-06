<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MatriculaController extends Controller
{
    public function index()
    {
        return Matricula::with('user', 'plano')
            ->where('academia_id', $this->academiaId())
            ->get();
    }

    public function show($id)
    {
        return $this->matriculasDaAcademia()->findOrFail($id);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'plano_id' => [
                'required',
                Rule::exists('planos', 'id')->where('academia_id', $this->academiaId()),
            ],
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'status' => 'required|string|max:255',
        ]);

        $nome = trim($data['nome']);
        $user = User::where('academia_id', $this->academiaId())
            ->where('name', $nome)
            ->first();

        if (!$user) {
            $user = User::create([
                'academia_id' => $this->academiaId(),
                'name' => $nome,
                'email' => Str::slug($nome).'-'.Str::lower(Str::random(8)).'@gym.local',
                'password' => bcrypt(Str::random(32)),
                'tipo' => 'aluno',
            ]);
        }

        $matricula = Matricula::create([
            'academia_id' => $this->academiaId(),
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
            'plano_id' => [
                'required',
                Rule::exists('planos', 'id')->where('academia_id', $this->academiaId()),
            ],
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'status' => 'required|string|max:255',
        ]);

        $matricula = $this->matriculasDaAcademia()->findOrFail($id);
        $matricula->update([
            'plano_id' => $data['plano_id'],
            'data_inicio' => $data['data_inicio'],
            'data_fim' => $data['data_fim'],
            'status' => $data['status'],
        ]);
        $matricula->user->update(['name' => trim($data['nome'])]);

        return response()->json([
            'success' => true,
            'matricula' => $matricula->load('user', 'plano'),
        ]);
    }

    public function destroy($id)
    {
        $this->matriculasDaAcademia()->findOrFail($id)->delete();

        return response()->json(['success' => true]);
    }

    public function alunosMatriculados()
    {
        return Matricula::with('user:id,name')
            ->where('academia_id', $this->academiaId())
            ->whereNotNull('user_id')
            ->get()
            ->map(fn ($matricula) => $matricula->user)
            ->filter()
            ->unique('id')
            ->values();
    }

    private function matriculasDaAcademia()
    {
        return Matricula::with('user', 'plano')
            ->where('academia_id', $this->academiaId());
    }
}
