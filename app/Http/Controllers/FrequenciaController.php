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
        return Frequencia::with('user')->findOrFail($id);
    }

    public function store(Request $request)
    {
        return Frequencia::create([
            'user_id' => $request->user_id,
            'entrada' => now()
        ]);
    }

    public function update(Request $request, $id)
    {
        $f = Frequencia::findOrFail($id);
        $f->update($request->all());

        return $f;
    }

    public function destroy($id)
    {
        Frequencia::findOrFail($id)->delete();

        return response()->json(['message' => 'ok']);
    }
}