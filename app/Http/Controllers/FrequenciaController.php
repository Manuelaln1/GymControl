<?php

namespace App\Http\Controllers;

use App\Models\Frequencia;
use Illuminate\Http\Request;

class FrequenciaController extends Controller
{
    public function index()
    {
        return Frequencia::with('user')->get();
    }

    public function show($id)
    {
        return Frequencia::with('user')
            ->findOrFail($id);
    }

    public function store(Request $request)
    {
        return Frequencia::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $frequencia = Frequencia::findOrFail($id);

        $frequencia->update($request->all());

        return $frequencia;
    }

    public function destroy($id)
    {
        Frequencia::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Frequência removida'
        ]);
    }
}