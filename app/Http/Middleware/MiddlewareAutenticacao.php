<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;

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
            if (!JWTAuth::getToken()) {
                return response(['errors' => 'Token de autenticação ausente. Realize o login novamente'], Response::HTTP_METHOD_NOT_ALLOWED);
            }
            try {
                JWTAuth::parseToken()->authenticate();
            } catch (TokenExpiredException $e) {
                return response(['errors' => 'Token de autenticação expirado. Por favor, realize o login novamente'], Response::HTTP_METHOD_NOT_ALLOWED);
            }
            return $next($request);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
