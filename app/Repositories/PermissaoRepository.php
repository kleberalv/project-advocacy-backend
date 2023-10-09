<?php

namespace App\Repositories;

use App\Models\FuncoesPermissoes;

/**
 * Classe responsável por acessar os dados relacionados às permissões.
 */
class PermissaoRepository
{
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
        return FuncoesPermissoes::join('tab_permissoes', 'tab_funcoes_permissoes.permissao_id', '=', 'tab_permissoes.id')
            ->where('tab_funcoes_permissoes.id_perfil', $idPerfil)
            ->where('tab_permissoes.action', $action)
            ->where('tab_permissoes.resource', $resource)
            ->exists();
    }
}
