<?php

namespace App\Helpers;

/**
 * Classe Helper para funções auxiliares diversas.
 */
class Helper
{
    /**
     * Formata o número de CPF removendo pontos e traços.
     *
     * @param array $data Os dados contendo o campo 'cpf'.
     * @return array Os dados com o campo 'cpf' formatado.
     */
    public static function formatCPF($data)
    {
        $cpf = isset($data['cpf']) ? str_replace(['.', '-'], '', $data['cpf']) : '';
        $data['cpf'] = $cpf;
        return $data;
    }
}
