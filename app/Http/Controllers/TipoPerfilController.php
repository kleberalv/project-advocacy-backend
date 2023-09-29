<?php

namespace App\Http\Controllers;

use Exception;
use App\Services\TipoPerfilService;
use Illuminate\Http\Response;

/**
 * Controlador para gerenciamento de tipos de perfis de usuário.
 */
class TipoPerfilController extends Controller
{
    /**
     * Instância do serviço de tipos de perfil.
     *
     * @var TipoPerfilService
     */
    private $tipoPerfilService;

    /**
     * Cria uma nova instância do controlador.
     *
     * @param TipoPerfilService $tipoPerfilService O serviço de tipos de perfil.
     */
    public function __construct(TipoPerfilService $tipoPerfilService)
    {
        $this->tipoPerfilService = $tipoPerfilService;
    }

    /**
     * Retorna os tipos de perfis de usuário.
     *
     * @return \Illuminate\Http\JsonResponse Os tipos de perfis de usuário.
     *
     * @throws Exception Em caso de erro na recuperação dos tipos de perfil.
     */
    public function index()
    {
        try {
            $profiles = $this->tipoPerfilService->profiles();
            return response()->json([
                'profiles' => $profiles['profiles'],
            ], $profiles['status']);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
