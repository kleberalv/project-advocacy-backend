<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\TokenUser;

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
     * Registra o token de acesso para o usuário no momento do login.
     *
     * @param User $user O usuário para o qual o token está sendo registrado.
     * @param string $token O token de acesso gerado.
     * @return TokenUser O token de usuário registrado salvo na tabela.
     */
    public function setTokenUserLogin($user, $token)
    {
        return TokenUser::create([
            'tokenable_type' => get_class($user),
            'tokenable_id_usuario' => $user['id_usuario'],
            'name_token' => 'JWT Access Token for ' . $user['nome'],
            'token' => $token,
            'id_perfil_permissions' => $user['id_perfil'],
            'expires_at' => now()->addHour(),
        ]);
    }

    /**
     * Regista o logout do usuário, excluindo logicamente o token do usuário.
     *
     * @param User $user O usuário para o qual o logout está sendo realizado.
     * @return void
     */
    public function setTokenUserLogout($user)
    {
        $lastToken = TokenUser::where('tokenable_id_usuario', $user['id_usuario'])
            ->orderByDesc('id_token')
            ->first();
        if ($lastToken) {
            $lastToken->deleted_at = now();
            $lastToken->save();
        }
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
