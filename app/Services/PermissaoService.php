<?php

namespace App\Services;

use App\Repositories\PermissaoRepository;

class PermissaoService
{
    protected $permissaoRepository;

    public function __construct(PermissaoRepository $permissaoRepository)
    {
        $this->permissaoRepository = $permissaoRepository;
    }

    public function verificarPermissao($idPerfil, $action, $resource)
    {
        return $this->permissaoRepository->verificarPermissao($idPerfil, $action, $resource);
    }
}
