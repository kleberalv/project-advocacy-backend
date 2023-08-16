<?php

namespace App\Repositories;

use App\Models\TipoPerfil;

/**
 * Classe responsável por acessar os dados relacionados aos tipos de perfil.
 */
class TipoPerfilRepository
{
    /**
     * Retorna os tipos de perfil.
     *
     * @return \Illuminate\Http\JsonResponse Os tipos de perfil.
     */
    public function profiles()
    {
        $tiposPerfil = TipoPerfil::all();
        return response()->json($tiposPerfil, 200);
    }
}