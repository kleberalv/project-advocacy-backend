<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Services\UserService;
use Illuminate\Http\Response;

/**
 * Controlador para gerenciamento de usuários.
 */
class UserController extends Controller
{
    /**
     * Instância do serviço de usuários.
     *
     * @var UserService
     */
    private $userService;

    /**
     * Cria uma nova instância do controlador.
     *
     * @param UserService $userService O serviço de usuários.
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Cria um novo usuário.
     *
     * @param Request $request A requisição contendo os dados do usuário.
     * @return \Illuminate\Http\JsonResponse Os dados do usuário criado.
     *
     * @throws Exception Em caso de erro na criação do usuário.
     */
    public function store(Request $request)
    {
        try {
            $validateFieldsOrFail = $this->userService->validateUserInput($request->all());
            if ($validateFieldsOrFail !== null) {
                return response()->json([
                    'message' => $validateFieldsOrFail['message'],
                ], $validateFieldsOrFail['status']);
            }
            $createUser = $this->userService->createUser($request->all());
            return response()->json([
                'message' => $createUser['message'],
            ], $createUser['status']);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Retorna a lista de usuários.
     *
     * @return \Illuminate\Http\JsonResponse A lista de usuários.
     *
     * @throws Exception Em caso de erro na recuperação da lista de usuários.
     */
    public function index()
    {
        try {
            $users = $this->userService->getIndex();
            return response()->json([
                'users' => $users['users'],
            ], $users['status']);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Atualiza um usuário existente.
     *
     * @param Request $request A requisição contendo os dados do usuário.
     * @return \Illuminate\Http\JsonResponse Os dados do usuário atualizado.
     *
     * @throws Exception Em caso de erro na atualização do usuário.
     */
    public function update(Request $request)
    {
        try {
            $validateFieldsOrFail = $this->userService->validateUserInput($request->all());
            if ($validateFieldsOrFail !== null) {
                return response()->json([
                    'message' => $validateFieldsOrFail['message'],
                ], $validateFieldsOrFail['status']);
            }
            $updateUserOrFail = $this->userService->updateUser($request->all());
            if ($updateUserOrFail !== null) {
                return response()->json([
                    'message' => $updateUserOrFail['message'],
                ], $updateUserOrFail['status']);
            }
            return response()->json([
                'message' => 'Usuário atualizado com sucesso!',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Exclui um usuário.
     *
     * @param Request $request A requisição contendo os dados do usuário a ser excluído.
     * @return \Illuminate\Http\JsonResponse Os dados do usuário excluído.
     *
     * @throws Exception Em caso de erro na exclusão do usuário.
     */
    public function destroy(Request $request)
    {
        try {
            $validateUserToDeleteOrFail = $this->userService->validateUserToDelete($request->all());
            if ($validateUserToDeleteOrFail !== null) {
                return response()->json([
                    'message' => $validateUserToDeleteOrFail['message'],
                ], $validateUserToDeleteOrFail['status']);
            }
            return response()->json([
                'message' => 'Usuário excluído com sucesso!',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
