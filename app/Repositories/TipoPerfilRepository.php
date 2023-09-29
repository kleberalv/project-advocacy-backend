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
     * @return \Illuminate\Database\Eloquent\Collection A coleção contendo os tipos de perfil.
     */
    public function profiles()
    {
        return TipoPerfil::all();
    }
}
