<?php

namespace App\Services;

use App\Helpers\Helper;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

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
     * @return array A resposta de erro em caso de validação falha.
     */
    public function validateFieldsLogin($data)
    {
        $data = Helper::formatCPF($data);
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
            return response(['errors' => $validator->errors()->all()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return;
    }

    /**
     * Valida o usuário para login e realiza a autenticação.
     *
     * @param array $userToAuthenticate Os dados do usuário para autenticação.
     * @return array Os dados do usuário.
     *
     * @return array Se o usuário não for encontrado, a senha estiver incorreta ou o usuário estiver desativado.
     */
    public function validateUserToLogin($userToAuthenticate)
    {
        $userToAuthenticate = Helper::formatCPF($userToAuthenticate);
        $user = $this->userRepository->getUserByCpf($userToAuthenticate);
        if (!$user) {
            return response()->json(['errors' => "Não foi encontrado um usuário com o CPF informado"], Response::HTTP_NOT_FOUND);
        }
        if ($user && $user->deleted_at !== null) {
            return response()->json(['errors' => "Este usuário está desativado"], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return $this->login($userToAuthenticate);
    }

    /**
     * Retorna informações sobre o usuário autenticado.
     *
     * @return \Illuminate\Http\JsonResponse As informações do usuário autenticado.
     */
    public function me()
    {
        $user = auth()->user();
        $userCollection = new UserCollection([$user]);
        return response()->json([
            'user' => $userCollection->toArray(),
            Response::HTTP_OK
        ]);
    }

    /**
     * Realiza o login do usuário.
     *
     * @param array $userToAuthenticate Os dados do usuário para autenticação.
     * @return array Os dados do usuário autenticado e o token de acesso.
     *
     * @return array Se o usuário não for encontrado ou a senha estiver incorreta.
     */
    public function login($userToAuthenticate)
    {
        $data = $this->userRepository->login($userToAuthenticate);
        if (!$data) {
            return response()->json(['errors' => "Não foi encontrado um usuário com o CPF informado"], Response::HTTP_NOT_FOUND);
        }
        if (!Hash::check($userToAuthenticate['senha'], $data['senha'])) {
            return response()->json(['errors' => "CPF ou senha incorretos. Por favor, verifique e tente novamente"], Response::HTTP_UNAUTHORIZED);
        }
        $token = auth()->login($data);
        $this->userRepository->setTokenUserLogin($data, $token);
        $userCollection = new UserCollection([$data]);
        return [
            'user' => $userCollection->toArray(),
            'access_token' => $token,
            Response::HTTP_OK
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
        return response()->json(['message' => 'Usuário deslogado com sucesso'], Response::HTTP_OK);
    }
}
