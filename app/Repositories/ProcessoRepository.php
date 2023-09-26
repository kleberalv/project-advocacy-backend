<?php

namespace App\Repositories;

use App\Models\Processo;

/**
 * Classe responsável por acessar o banco de dados e recuperar informações relacionadas a processos.
 */
class ProcessoRepository
{
    /**
     * Cria um novo processo no banco de dados.
     *
     * @param array $process Os dados do processo a serem criados.
     * @return Processo O processo criado.
     */
    public function createProcess($process)
    {
        return Processo::create($process);
    }

    /**
     * Obtém a lista de processos com relacionamentos.
     *
     * @return \Illuminate\Database\Eloquent\Collection A coleção de processos com relacionamentos carregados.
     */
    public function getIndex()
    {
        $processos = Processo::with('advogado', 'cliente', 'status')->get();
        return $processos;
    }
}
