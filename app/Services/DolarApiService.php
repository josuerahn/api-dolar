<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

class DolarApiService
{

    public function fetch(string $tipo = 'oficial'): array

    {
        $baseUrl = config('services.dolar-api.url');
        $response = Http::get("{$baseUrl}/{$tipo}")->throw()->json();

         return [
            'compra' => $data['compra'] ?? null,
            'venta' => $data['venta'] ?? null,
            'fecha' => isset($data['fechaActualizacion']) ? Carbon::parse($response['fechaActualizacion'])->timezone('America/Argentina/Cordoba') : now('America/Argentina/Cordoba'),
            'fuente' =>  'dolarapi.com'
        ];
    }
}