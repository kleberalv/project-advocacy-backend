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
            $cpf = str_replace(['.', '-'], '', $request->cpf);
            $request->merge(['cpf' => $cpf]);
            $validator = Validator::make($request->all(), [
                'nome' => 'required|string|max:255',
                'cpf' => 'required|string|max:11|unique:tab_usuarios',
                'senha' => 'string|min:8|max:20',
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
                'senha' => $request->senha ? Hash::make($request->senha) : Hash::make('PrimeiroAcesso2023'),
                'email' => $request->email,
                'dat_nasc' => $request->dat_nasc,
                'id_perfil' => $request->id_perfil ? $request->id_perfil : 3,
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

    public function update(Request $request)
    {
        $cpf = str_replace(['.', '-'], '', $request->cpf);
        $request->merge(['cpf' => $cpf]);

        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|max:255',
                'nome' => 'required|string|max:255',
                'cpf' => 'required|string|max:11',
                'senha' => 'string|min:8|max:20',
                'email' => 'required|string|email|max:255',
                'dat_nasc' => 'required|date',
                'id_perfil' => 'required|integer',
                'endereco' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Ocorreu um erro na atualização. Por favor, tente novamente',
                    'errors' => $validator->errors()
                ], 404);
            }

            $user = User::where('cpf', $request->cpf)->first();

            if ($user && $user->id_usuario !== $request->id) {
                // O CPF já está cadastrado para outro usuário
                return response()->json([
                    'message' => 'CPF já cadastrado para outro usuário.',
                ], 400);
            }

            $user = User::findOrFail($request->id);

            $user->nome = $request->nome;
            $user->cpf = $request->cpf;
            $user->senha = $request->senha ? Hash::make($request->senha) : $user->senha;
            $user->email = $request->email;
            $user->dat_nasc = $request->dat_nasc;
            $user->id_perfil = $request->id_perfil;
            $user->endereco = $request->endereco;

            $user->save();

            return response()->json([
                'message' => 'Usuário atualizado com sucesso!',
                'user' => $user,
            ], 200);
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
