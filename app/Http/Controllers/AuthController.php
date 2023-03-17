<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserCollection;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'cpf' => 'required|string|max:11',
            'senha' => 'required|string|max:20'
        ], [
            'cpf.required' => 'O campo CPF é obrigatório.',
            'senha.required' => 'O campo senha é obrigatório.',
            'cpf.max' => 'O campo CPF deve ter no máximo 11 caracteres.',
            'senha.max' => 'O campo senha deve ter no máximo 20 caracteres.'
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        // Busca o usuário com o CPF informado
        $user = User::where('cpf', $request->cpf)->first();

        // Verifica se o usuário foi encontrado e se a senha informada está correta
        if (!$user || !Hash::check($request->senha, $user->senha)) {
            return response()->json(['error' => 'CPF ou senha incorretos. Por favor, verifique e tente novamente.'], 401);
        }

        $token = auth()->login($user);
        $userCollection = new UserCollection([$user]);

        return response()->json([
            'user' => $userCollection->toArray()
            ,
            'access_token' => $token
        ]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = auth()->user();
        $userCollection = new UserCollection([$user]);
    
        return response()->json([
            'user' => $userCollection->toArray()
        ]);
    }    

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
