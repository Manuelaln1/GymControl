<?php

namespace App\Http\Controllers;

use App\Models\TreinoExercicio;
use Illuminate\Http\Request;

class TreinoExercicioController extends Controller
{
    public function index()
    {
        return TreinoExercicio::with(
            'treino',
            'exercicio'
        )->get();
    }

    public function store(Request $request)
    {
        return TreinoExercicio::create($request->all());
    }

    public function show($id)
    {
        return TreinoExercicio::with(
            'treino',
            'exercicio'
        )->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $registro = TreinoExercicio::findOrFail($id);

        $registro->update($request->all());

        return $registro;
    }

    public function destroy($id)
    {
        TreinoExercicio::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Registro removido'
        ]);
    }
}