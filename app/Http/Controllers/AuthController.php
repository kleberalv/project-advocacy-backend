<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Controllers\Controller;
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
            $validateFieldsOrFail = $this->authService->validateFieldsLogin($request->all());
            if ($validateFieldsOrFail !== null) {
                return response()->json([
                    'message' => $validateFieldsOrFail['message'],
                ], $validateFieldsOrFail['status']);
            }
            $validateUserToLoginOrFail = $this->authService->validateUserToLogin($request->all());
            if ($validateUserToLoginOrFail !== null) {
                return response()->json([
                    'message' => $validateUserToLoginOrFail['message'],
                ], $validateUserToLoginOrFail['status']);
            }
            $authenticateUser = $this->authService->login($request->all());
            return response()->json(
                [
                    'user' => $authenticateUser['user'],
                    'access_token' => $authenticateUser['access_token']
                ],
                $authenticateUser['status']
            )->header(
                'Authorization',
                'Bearer ' . $authenticateUser['access_token']
            );
        } catch (\Exception $e) {
            if ($e instanceof \Illuminate\Database\QueryException) {
                return response()->json([
                    'message' => 'Ocorreu um erro interno no servidor. Por favor, tente novamente mais tarde',
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            throw new Exception($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Retorna os dados do usuário autenticado.
     *
     * @return \Illuminate\Http\JsonResponse Os dados do usuário autenticado.
     *
     * @throws Exception Em caso de erro ao recuperar os dados do usuário autenticado.
     */
    public function me()
    {
        try {
            $myUser = $this->authService->me();
            return response()->json([
                'user' => $myUser['user'],
            ], $myUser['status']);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Realiza o processo de logout do usuário autenticado.
     *
     * @return \Illuminate\Http\JsonResponse A mensagem de sucesso no logout.
     *
     * @throws Exception Em caso de erro durante o logout.
     */
    public function logout()
    {
        try {
            $userToLogout = $this->authService->logout();
            return response()->json([
                'message' => $userToLogout['message'],
            ], $userToLogout['status']);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
