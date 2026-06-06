<?php

namespace App\Http\Controllers;

use App\Models\Frequencia;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class FrequenciaController extends Controller
{
    public function index()
    {
        return Frequencia::with('user')
            ->where('academia_id', $this->academiaId())
            ->get();
    }

    public function show($id)
    {
        return $this->frequenciasDaAcademia()->findOrFail($id);
    }

    public function store(Request $request)
    {
        $data = $this->validateFrequencia($request);

        return Frequencia::create([
            'academia_id' => $this->academiaId(),
            'user_id' => $data['user_id'],
            'entrada' => isset($data['data']) ? Carbon::parse($data['data'])->startOfDay() : now(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $this->validateFrequencia($request);
        $frequencia = $this->frequenciasDaAcademia()->findOrFail($id);
        $frequencia->update([
            'user_id' => $data['user_id'],
            'entrada' => isset($data['data']) ? Carbon::parse($data['data'])->startOfDay() : $frequencia->entrada,
        ]);

        return $frequencia;
    }

    public function destroy($id)
    {
        $this->frequenciasDaAcademia()->findOrFail($id)->delete();

        return response()->json(['message' => 'ok']);
    }

    private function validateFrequencia(Request $request): array
    {
        return $request->validate([
            'user_id' => [
                'required',
                Rule::exists('users', 'id')->where('academia_id', $this->academiaId()),
            ],
            'data' => 'nullable|date',
        ]);
    }

    private function frequenciasDaAcademia()
    {
        return Frequencia::with('user')
            ->where('academia_id', $this->academiaId());
    }
}
