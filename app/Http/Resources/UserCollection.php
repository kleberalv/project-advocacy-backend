<?php

namespace App\Http\Resources;

use Illuminate\Support\Collection;

/**
 * Classe para transformar uma coleção de recursos de usuário em um array.
 */
class UserCollection extends Collection
{
    /**
     * Transforma a coleção de recursos em um array.
     *
     * @return array O array contendo os recursos de usuário transformados.
     */
    public function toArray()
    {
        return $this->map(function ($user) {
            return $user->toArray();
        })->all();
    }
}
