<?php

namespace App\Http\Controllers;

use App\Models\TipoPerfil;

class TipoPerfilController extends Controller
{
    public function index()
    {
        $tiposPerfil = TipoPerfil::all();
        return response()->json($tiposPerfil, 200);
    }
}
