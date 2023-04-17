<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserCollection;
use Exception;

class UserController extends Controller
{
    public function store(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'nome' => 'required|string|max:255',
                'cpf' => 'required|string|max:11|unique:tab_usuarios',
                'senha' => 'required|string|min:8|max:20',
                'email' => 'required|string|email|max:255',
                'dat_nasc' => 'required|date',
                'id_perfil' => 'required|integer',
                'endereco' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Ocorreu um erro no cadastro. Por favor, tente novamente',
                    'errors' => $validator->errors()
                ], 404);
            }

            $user = User::create([
                'nome' => $request->nome,
                'cpf' => $request->cpf,
                'senha' => Hash::make($request->senha),
                'email' => $request->email,
                'dat_nasc' => $request->dat_nasc,
                'id_perfil' => $request->id_perfil,
                'endereco' => $request->endereco,
            ]);

            return response()->json([
                'message' => 'Usuário criado com sucesso!',
                'user' => $user,
            ], 201);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }

    public function allUsers()
    {
        try {
            $user = auth()->user();
            if (!$user) {
                throw new Exception('Usuário não autenticado. Por favor, realize o logon na plataforma novamente.', 401);
            }
            $users = User::all();
            $userCollection = new UserCollection($users);
            return response()->json([
                'users' => $userCollection->toArray()
            ]);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), 401);
        }
    }
}
