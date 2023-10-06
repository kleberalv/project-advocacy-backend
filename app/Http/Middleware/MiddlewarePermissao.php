<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\PermissaoService;

/**
 * Middleware para verificação de permissão de usuário.
 */
class MiddlewarePermissao
{

    protected $permissaoService;

    public function __construct(PermissaoService $permissaoService)
    {
        $this->permissaoService = $permissaoService;
    }

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
            $action = $request->method();
            $resource = $request->route()->getName();
            $hasPermission = $this->permissaoService->verificarPermissao($user->id_perfil, $action, $resource);
            if (!$hasPermission) {
                return response(['errors' => 'Usuário não possui autorização para essa ação'], Response::HTTP_METHOD_NOT_ALLOWED);
            }
            return $next($request);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
