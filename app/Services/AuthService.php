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
     * @param array $filledFields Os dados de entrada para validação.
     * @return array|null A resposta de erro em caso de validação falha.
     */
    public function validateFieldsLogin($filledFields)
    {
        $filledFields = Helper::formatCPF($filledFields);
        $rules = [
            'cpf' => 'required|string|max:11',
            'senha' => 'required|string|max:20'
        ];
        $customMessages = [
            '*' => [
                'required' => 'O campo :attribute é obrigatório',
                'max' => 'O campo :attribute deve conter no máximo :max caracteres',
            ],
        ];
        $validator = Validator::make($filledFields, $rules, $customMessages);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessage = 'Ocorreu o seguinte erro na operação: ' . implode(', ', $errors);
            return [
                'message' => $errorMessage,
                'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
            ];
        }
        return null;
    }

    /**
     * Valida as credenciais do usuário para o enviar a função de login.
     *
     * @param array $filledFields Os dados do usuário para autenticação, incluindo CPF e senha.
     * @return array|null Os dados do usuário para ser autenticado ou resposta de erro.
     */
    public function validateUserToLogin($filledFields)
    {
        $filledFields = Helper::formatCPF($filledFields);
        $user = $this->userRepository->getUserByCpf($filledFields);
        if (!$user) {
            return [
                'message' => 'Não foi encontrado um usuário com o CPF informado',
                'status' => Response::HTTP_NOT_FOUND,
            ];
        }
        if (!Hash::check($filledFields['senha'], $user->senha)) {
            return [
                'message' => 'CPF ou senha incorretos. Por favor, verifique e tente novamente',
                'status' => Response::HTTP_UNAUTHORIZED,
            ];
        }
        if ($user && $user->deleted_at !== null) {
            return [
                'message' => 'Este usuário está desativado',
                'status' => Response::HTTP_FORBIDDEN,
            ];
        }
        return null;
    }

    /**
     * Retorna informações sobre o usuário autenticado.
     *
     * @return array As informações do usuário autenticado.
     */
    public function me()
    {
        $userCollection = new UserCollection([auth()->user()]);
        return [
            'user' => $userCollection->toArray(),
            'status' => Response::HTTP_OK
        ];
    }

    /**
     * Realiza o login do usuário.
     *
     * @param array $userToAuthenticate Os dados do usuário para autenticação.
     * @return array|null Os dados do usuário autenticado e o token de acesso ou resposta de erro.
     */
    public function login($userToAuthenticate)
    {
        $userToAuthenticate = Helper::formatCPF($userToAuthenticate);
        $user = $this->userRepository->login($userToAuthenticate);
        $token = auth()->login($user);
        $this->userRepository->setTokenUserLogin($user, $token);
        $userCollection = new UserCollection([$user]);
        return [
            'user' => $userCollection->toArray(),
            'access_token' => $token,
            'status' => Response::HTTP_OK,
        ];
    }

    /**
     * Realiza o logout do usuário autenticado.
     *
     * @return array A resposta de sucesso do logout.
     */
    public function logout()
    {
        $user = auth()->user();
        if (!$user) {
            return [
                'message' => 'Este usuário já não está mais autenticado',
                'status' => Response::HTTP_OK,
            ];
        }
        $this->userRepository->setTokenUserLogout($user);
        return [
            'message' => 'Usuário deslogado com sucesso',
            'status' => Response::HTTP_OK,
        ];
    }
}
