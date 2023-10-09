<?php

namespace App\Services;

use App\Repositories\PermissaoRepository;

/**
 * Classe de serviço para manipulação de permissões.
 */
class PermissaoService
{
    /**
     * Repositório de permissões.
     *
     * @var PermissaoRepository
     */
    protected $permissaoRepository;

    /**
     * Cria uma nova instância do serviço.
     *
     * @param PermissaoRepository $permissaoRepository O repositório de permissões.
     */
    public function __construct(PermissaoRepository $permissaoRepository)
    {
        $this->permissaoRepository = $permissaoRepository;
    }

    /**
     * Verifica se um perfil tem a permissão específica.
     *
     * @param int $idPerfil O ID do perfil a ser verificado.
     * @param string $action A ação da permissão.
     * @param string $resource O recurso da permissão.
     * @return bool Retorna true se o perfil tiver a permissão e false caso contrário.
     */
    public function verificarPermissao($idPerfil, $action, $resource)
    {
        return $this->permissaoRepository->verificarPermissao($idPerfil, $action, $resource);
    }
}
