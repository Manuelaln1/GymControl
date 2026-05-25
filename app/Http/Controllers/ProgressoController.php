<?php

namespace App\Http\Controllers;

use App\Models\Progresso;
use Illuminate\Http\Request;

class ProgressoController extends Controller
{
    public function index()
    {
        return Progresso::with(
            'aluno',
            'professor'
        )->get();
    }

    public function show($id)
    {
        return Progresso::with(
            'aluno',
            'professor'
        )->findOrFail($id);
    }

    public function store(Request $request)
    {
        return Progresso::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $progresso = Progresso::findOrFail($id);

        $progresso->update($request->all());

        return $progresso;
    }

    public function destroy($id)
    {
        Progresso::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Progresso removido'
        ]);
    }
}