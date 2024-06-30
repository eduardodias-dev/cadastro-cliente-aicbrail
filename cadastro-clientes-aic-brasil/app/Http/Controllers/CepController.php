<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CepController extends Controller
{
    //
    public function getCepData($cep)
    {
        $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['error' => 'CEP not found'], 404);
    }
}
