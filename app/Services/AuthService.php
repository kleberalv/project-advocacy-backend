<?php

namespace App\Services;

use Exception;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserCollection;
use Illuminate\Support\Facades\Validator;

/**
 * Classe responsável por fornecer serviços relacionados à autenticação e gerenciamento de usuários.
 */
class AuthService
{
    /**
     * Repositório de usuário.
     *
     * @var UserRepository
     */
    private $userRepository;

    /**
     * Cria uma nova instância do serviço.
     *
     * @param UserRepository $userRepository O repositório de usuário.
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Valida os campos necessários para o login.
     *
     * @param array $data Os dados de entrada para validação.
     * @return \Illuminate\Http\JsonResponse|null A resposta de erro em caso de validação falha.
     */
    public function validateFieldsLogin($data)
    {

        $rules = [
            'cpf' => 'required|string|max:11',
            'senha' => 'required|string|max:20'
        ];

        $customMessages = [
            'cpf.required' => 'O campo CPF é obrigatório.',
            'senha.required' => 'O campo senha é obrigatório.',
            'cpf.max' => 'O campo CPF deve ter no máximo 11 caracteres.',
            'senha.max' => 'O campo senha deve ter no máximo 20 caracteres.'
        ];

        $validator = Validator::make($data, $rules, $customMessages);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        return;
    }

    /**
     * Valida o usuário para login e realiza a autenticação.
     *
     * @param array $userToAuthenticate Os dados do usuário para autenticação.
     * @return array Os dados do usuário autenticado e o token de acesso.
     *
     * @throws Exception Se o usuário não for encontrado ou a senha estiver incorreta.
     */
    public function validateUserToLogin($userToAutenticate)
    {

        $user = $this->userRepository->getUserByCpf($userToAutenticate['cpf']);
        if (!$user) {
            throw new Exception('Não foi encontrado um usuário com o CPF informado', 404);
        }
        return $this->login($userToAutenticate, $user);
    }

    /**
     * Retorna informações sobre o usuário autenticado (usuário "me").
     *
     * @return \Illuminate\Http\JsonResponse As informações do usuário autenticado.
     */
    public function me()
    {
        $user = auth()->user();
        $userCollection = new UserCollection([$user]);

        return response()->json([
            'user' => $userCollection->toArray()
        ]);
    }

    /**
     * Realiza o login do usuário.
     *
     * @param array $userToAuthenticate Os dados do usuário para autenticação.
     * @param array $user Os dados do usuário autenticado.
     * @return array Os dados do usuário autenticado e o token de acesso.
     *
     * @throws Exception Se o usuário não for encontrado ou a senha estiver incorreta.
     */
    public function login($userToAutenticate, $user)
    {
        $data = $this->userRepository->login($userToAutenticate, $user);

        if (!$data || !Hash::check($userToAutenticate['senha'], $data['senha'])) {
            throw new Exception('CPF ou senha incorretos. Por favor, verifique e tente novamente.', 401);
        }
        $token = auth()->login($data);
        $this->userRepository->setTokenUserLogin($data, $token);
        $userCollection = new UserCollection([$data]);
        return [
            'user' => $userCollection->toArray(),
            'access_token' => $token
        ];
    }

    /**
     * Realiza o logout do usuário autenticado.
     *
     * @return \Illuminate\Http\JsonResponse A resposta de sucesso do logout.
     */
    public function logout()
    {
        $user = auth()->user();
        $this->userRepository->setTokenUserLogout($user);
        Auth::logout();
        return response()->json(['message' => 'Usuário deslogado com sucesso']);
    }
}
