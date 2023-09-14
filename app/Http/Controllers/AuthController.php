<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Controlador responsável pela autenticação e gerenciamento de usuários.
 */
class AuthController extends Controller
{
    /**
     * Instância do serviço de autenticação.
     *
     * @var AuthService
     */
    private $authService;

    /**
     * Cria uma nova instância do controlador.
     *
     * @param AuthService $authService O serviço de autenticação.
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Realiza o processo de autenticação do usuário.
     *
     * @param Request $request A requisição contendo os dados de login.
     * @return \Illuminate\Http\JsonResponse Os dados do usuário autenticado.
     *
     * @throws Exception Em caso de erro durante a autenticação.
     */
    public function login(Request $request)
    {
        try {
            $validationResponse = $this->authService->validateFieldsLogin($request->all());
            if ($validationResponse !== null) {
                return $validationResponse;
            }
            $user = $this->authService->validateUserToLogin($request->all());
            if ($user instanceof JsonResponse && $user->getStatusCode() !== Response::HTTP_OK) {
                return $user;
            }
            return response()->json($user);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Retorna os dados do usuário autenticado.
     *
     * @return \Illuminate\Http\JsonResponse Os dados do usuário autenticado.
     */
    public function me()
    {
        try {
            return $this->authService->me();
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Realiza o processo de logout do usuário autenticado.
     *
     * @return \Illuminate\Http\JsonResponse A mensagem de sucesso no logout.
     */
    public function logout()
    {
        try {
            return $this->authService->logout();
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
