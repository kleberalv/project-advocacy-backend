<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware para verificação de permissão de usuário.
 */
class MiddlewarePermissao
{
    /**
     * Manipula a requisição, verificando a permissão do usuário.
     *
     * @param Request $request A requisição HTTP.
     * @param Closure $next O próximo passo na cadeia de middlewares.
     * @return Response A resposta HTTP.
     *
     * @throws \Exception Em caso de permissão negada.
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = auth()->user();
            if ($user->id_perfil === 3 && $request->method() !== 'GET') {
                return response(['errors' => 'Usuário não possui autorização para essa ação'], Response::HTTP_METHOD_NOT_ALLOWED);
            }
            return $next($request);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
