<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class UserCollection extends Collection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
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
