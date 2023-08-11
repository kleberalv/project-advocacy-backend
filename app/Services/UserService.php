<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Helper;
use Exception;

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function validateUserInput(array $data)
    {
        $data = Helper::formatCPF($data);
        $rules = [
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:11|unique:tab_usuarios,cpf,' . ($data['id'] ?? 'null') . ',id_usuario',
            'senha' => 'string|min:8|max:20',
            'email' => 'required|string|email|max:255',
            'dat_nasc' => 'required|date',
            'id_perfil' => 'required|integer',
            'endereco' => 'required|string|max:255',
        ];
        $customMessages = [
            '*' => [
                'required' => 'O campo :attribute é obrigatório',
                'min' => 'O campo :attribute deve conter no mínimo :min caracteres',
                'max' => 'O campo :attribute deve conter no máximo :max caracteres',
            ],
            'cpf.unique' => 'Este CPF já está cadastrado para outro usuário',
        ];
        $validator = Validator::make($data, $rules, $customMessages);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessage = 'Ocorreu o seguinte erro na operação: ' . implode(', ', $errors);

            return response()->json([
                'message' => $errorMessage,
            ], 404);
        }
        return;
    }

    private function senhaUser($data)
    {
        $senha = isset($data['senha']) ? Hash::make($data['senha']) : Hash::make('PrimeiroAcesso2023');
        $data['senha'] = $senha;
        return $data;
    }

    public function validateUserToDelete($user)
    {
        $data = $this->userRepository->getUserById($user);
        if (!$data) {
            throw new Exception('Usuário não encontrado', 404);
        }
        return $this->deleteUser($data);
    }

    public function getIndex()
    {
        $users = $this->userRepository->getIndex();
        return $users;
    }

    public function createUser($user)
    {
        $data = Helper::formatCPF($user);
        $dados = $this->senhaUser($data);
        return $this->userRepository->createUser($dados);
    }

    public function updateUser($user)
    {
        $data = Helper::formatCPF($user);
        if (isset($user['senha'])) {
            $data = $this->senhaUser($user);
        }
        return $this->userRepository->updateUser($data);
    }

    public function deleteUser($user)
    {
        return $user = $this->userRepository->deleteUser((object)$user);
    }
}
