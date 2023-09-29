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
     * Obtém um processo pelo seu ID.
     *
     * @param array $process Os dados do processo a serem recuperados.
     * @return Processo|null O processo correspondente ou nulo se não encontrado.
     */
    public function getProcessById($process)
    {
        return Processo::with('advogado', 'cliente', 'status')->where('id_processo', $process['id_processo'])->first();
    }

    /**
     * Obtém a lista de processos com relacionamentos.
     *
     * @return \Illuminate\Database\Eloquent\Collection A coleção de processos com relacionamentos carregados.
     */
    public function getIndex()
    {
        return Processo::whereNull('deleted_at')->with('advogado', 'cliente', 'status')->get();
    }

    /**
     * Atualiza um processo existente com os dados fornecidos.
     *
     * @param array $process Os dados do processo a serem atualizados.
     * @param Processo $processToUpdate O processo a ser atualizado.
     * @return Processo O processo atualizado.
     */
    public function updateProcess($process, Processo $processToUpdate)
    {
        foreach ($process as $field => $value) {
            if (in_array($field, $processToUpdate->getFillable())) {
                $processToUpdate->$field = $value;
            }
        }
        $processToUpdate->updated_at = now();
        $processToUpdate->save();
        return $processToUpdate;
    }

    /**
     * Exclui um processo existente.
     *
     * @param Processo $process O processo a ser excluído.
     * @return Processo O processo excluído.
     */
    public function deleteProcess(Processo $process)
    {
        $process->deleted_at = now();
        $process->save();
        return $process;
    }
}
