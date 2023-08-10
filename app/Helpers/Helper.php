<?php

namespace App\Helpers;

class Helper
{

    public static function formatCPF($data)
    {
        $cpf = isset($data['cpf']) ? str_replace(['.', '-'], '', $data['cpf']) : '';
        $data['cpf'] = $cpf;
        return $data;
    }
}
