<?php

namespace App\Repositories;

use App\Models\Sexo;

/**
 * Repositório para acessar dados relacionados aos sexos.
 */
class SexoRepository
{
    /**
     * Retorna a lista de sexos.
     *
     * @return \Illuminate\Database\Eloquent\Collection A lista de sexos ativos.
     */
    public function getIndex()
    {
        return Sexo::whereNull('deleted_at')->get();
    }
}
