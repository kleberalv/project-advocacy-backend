<?php

namespace App\Repositories;

use App\Models\FuncoesPermissoes;

class PermissaoRepository
{
    public function verificarPermissao($idPerfil, $action, $resource)
    {
        return FuncoesPermissoes::join('tab_permissoes', 'tab_funcoes_permissoes.permissao_id', '=', 'tab_permissoes.id')
            ->where('tab_funcoes_permissoes.id_perfil', $idPerfil)
            ->where('tab_permissoes.action', $action)
            ->where('tab_permissoes.resource', $resource)
            ->exists();
    }
}
