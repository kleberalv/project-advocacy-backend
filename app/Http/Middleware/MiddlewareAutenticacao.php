<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

/**
 * Middleware para autenticação JWT.
 */
class MiddlewareAutenticacao
{
    /**
     * Manipula a requisição, verificando a autenticação JWT.
     *
     * @param Request $request A requisição HTTP.
     * @param Closure $next O próximo passo na cadeia de middlewares.
     * @return Response A resposta HTTP.
     *
     * @throws \Exception Em caso de erro de autenticação ou usuário não autenticado.
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            throw new \Exception('Usuário não autenticado. Por favor, realize o logon na plataforma novamente.', 401);
        }
        return $next($request);
    }
}
