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
        $user = auth()->user();
        if ($user->id_perfil !== 1) {
            throw new \Exception('Usuário não possui autorização para acessar esta funcionalidade.', 403);
        }
        return $next($request);
    }
}
