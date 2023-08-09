<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MiddlewarePermissao
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
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
