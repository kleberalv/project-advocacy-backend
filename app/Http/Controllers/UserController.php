<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserCollection;
use Exception;
use App\Services\UserService;
use App\Repositories\UserRepository;

class UserController extends Controller
{

    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

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
