<?php

namespace App\Repositories;

use App\Models\User;

/**
 * Classe responsável por acessar os dados relacionados aos usuários.
 */
class UserRepository
{
    /**
     * Realiza a autenticação do usuário com base no CPF.
     *
     * @param array $userToAuthenticate Os dados do usuário para autenticação.
     * @return User|null O usuário autenticado ou null se não encontrado.
     */
    public function login($userToAuthenticate, $user)
    {
        $user = User::where('cpf', $userToAuthenticate['cpf'])->first();
        return $user;
    }

    /**
     * Retorna um usuário pelo seu ID.
     *
     * @param array $user Os dados do usuário.
     * @return User|null O usuário encontrado ou null se não encontrado.
     */
    public function getUserById($user)
    {
        $user = User::where('id_usuario', $user['id'])->first();
        return $user;
    }

    /**
     * Retorna um usuário pelo seu CPF.
     *
     * @param string $cpf O CPF do usuário.
     * @return User|null O usuário encontrado ou null se não encontrado.
     */
    public function getUserByCpf($cpf)
    {
        return User::where('cpf', $cpf)->first();
    }

    /**
     * Retorna a lista de usuários.
     *
     * @return \Illuminate\Database\Eloquent\Collection A lista de usuários.
     */
    public function getIndex()
    {
        return User::whereNull('deleted_at')->get();
    }

    /**
     * Cria um novo usuário.
     *
     * @param array $user Os dados do novo usuário.
     * @return User O usuário criado.
     */
    public function createUser($user)
    {
        return User::create($user);
    }

    /**
     * Atualiza um usuário existente.
     *
     * @param array $user Os dados do usuário a serem atualizados.
     * @return User O usuário atualizado.
     */
    public function updateUser($user)
    {
        $userToUpdate = User::find($user['id']);
        if (!$userToUpdate) {
            throw new \Exception('Usuário não encontrado', 404);
        }
        foreach ($user as $field => $value) {
            if (in_array($field, $userToUpdate->getFillable())) {
                $userToUpdate->$field = $value;
            }
        }
        $userToUpdate->save();
        return $userToUpdate;
    }

    /**
     * Exclui logicamente um usuário.
     *
     * @param User $user O usuário a ser excluído.
     * @return User O usuário excluído.
     */
    public function deleteUser($user)
    {
        $user->deleted_at = now();
        $user->save();
        return $user;
    }
}