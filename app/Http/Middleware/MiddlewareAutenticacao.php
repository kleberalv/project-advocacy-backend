<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class MiddlewareAutenticacao
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
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
