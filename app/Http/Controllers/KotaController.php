<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class KotaController extends Controller
{
    public function kota($provinsiId)
    {
        $url = 'https://www.emsifa.com/api-wilayah-indonesia/api/regencies/' . $provinsiId . '.json';
        $response = Http::get($url);
        $kotas = $response->json();
        return response()->json($kotas);
    }
}
