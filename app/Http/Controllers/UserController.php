<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserCollection;
use Exception;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
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
            $validationResponse = $this->userService->validateUserInput($request->all());
            if ($validationResponse !== null) {
                return $validationResponse;
            }
            $user = $this->userService->createUser($request->all());
            return response()->json([
                'message' => 'Usuário criado com sucesso!',
                'user' => (new UserCollection([$user]))->toArray(),
            ], Response::HTTP_CREATED);
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
                'users' => $users,
            ]);
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
            $validationResponse = $this->userService->validateUserInput($request->all());
            if ($validationResponse !== null) {
                return $validationResponse;
            }
            $user = $this->userService->updateUser($request->all());
            if ($user instanceof JsonResponse && $user->getStatusCode() !== Response::HTTP_OK) {
                return $user;
            }
            return response()->json([
                'message' => 'Usuário atualizado com sucesso!',
                'user' => (new UserCollection([$user]))->toArray(),
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
            $user = $this->userService->validateUserToDelete($request->all());
            if ($user instanceof JsonResponse && $user->getStatusCode() !== Response::HTTP_OK) {
                return $user;
            }
            return response()->json([
                'message' => 'Usuário excluído com sucesso!',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
