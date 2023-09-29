<?php

namespace App\Services;

use Illuminate\Http\Response;
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
     * @return array As informações dos tipos de perfil e o status da resposta.
     */
    public function profiles()
    {
        $profiles = $this->tipoPerfilRepository->profiles();
        return [
            'profiles' => $profiles,
            'status' => Response::HTTP_OK
        ];
    }
}
