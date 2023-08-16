<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserCollection;
use Exception;
use App\Services\UserService;

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
            ], 201);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), 401);
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
            throw new Exception($e->getMessage(), 401);
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
            return response()->json([
                'message' => 'Usuário atualizado com sucesso!',
                'user' => (new UserCollection([$user]))->toArray(),
            ], 200);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), 401);
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
    public function delete(Request $request)
    {
        try {
            $user = $this->userService->validateUserToDelete($request->all());
            return response()->json([
                'message' => 'Usuário excluído com sucesso!',
                'user' => (new UserCollection([$user]))->toArray(),
            ], 200);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), 401);
        }
    }
}
