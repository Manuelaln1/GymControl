<?php

namespace App\Http\Controllers;

use App\Models\Frequencia;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
        $data = $this->validateFrequencia($request);

        return Frequencia::create([
            'user_id' => $data['user_id'],
            'entrada' => isset($data['data']) ? Carbon::parse($data['data'])->startOfDay() : now(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $this->validateFrequencia($request);
        $frequencia = Frequencia::findOrFail($id);
        $frequencia->update([
            'user_id' => $data['user_id'],
            'entrada' => isset($data['data']) ? Carbon::parse($data['data'])->startOfDay() : $frequencia->entrada,
        ]);

        return $frequencia;
    }

    public function destroy($id)
    {
        Frequencia::findOrFail($id)->delete();

        return response()->json(['message' => 'ok']);
    }

    private function validateFrequencia(Request $request): array
    {
        return $request->validate([
            'user_id' => 'required|exists:users,id',
            'data' => 'nullable|date',
        ]);
    }
}
