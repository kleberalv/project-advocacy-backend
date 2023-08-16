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
     * @return array<int|string, mixed> O array contendo os recursos de usuário transformados.
     */
    public function toArray()
    {
        return $this->map(function ($user) {
            return [
                'id_usuario' => $user->id_usuario,
                'nome' => $user->nome,
                'cpf' => $user->cpf,
                'email' => $user->email,
                'dat_nasc' => $user->dat_nasc,
                'id_perfil' => $user->id_perfil,
                'endereco' => $user->endereco,
            ];
        })->all();
    }
}
