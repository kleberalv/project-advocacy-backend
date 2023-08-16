<?php

namespace App\Services;

use App\Repositories\TipoPerfilRepository;

/**
 * Classe responsável por fornecer serviços relacionados aos tipos de perfil.
 */
class TipoPerfilService
{
    /**
     * Repositório de tipos de perfil.
     *
     * @var TipoPerfilRepository
     */
    private $tipoPerfilRepository;

    /**
     * Cria uma nova instância do serviço.
     *
     * @param TipoPerfilRepository $tipoPerfilRepository O repositório de tipos de perfil.
     */
    public function __construct(TipoPerfilRepository $tipoPerfilRepository)
    {
        $this->tipoPerfilRepository = $tipoPerfilRepository;
    }

    /**
     * Retorna os tipos de perfil.
     *
     * @return \Illuminate\Http\JsonResponse Os tipos de perfil.
     */
    public function profiles()
    {
        return $this->tipoPerfilRepository->profiles();
    }
}