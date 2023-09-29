<?php

namespace App\Services;

use App\Repositories\ProcessoRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

/**
 * Classe responsável por fornecer serviços relacionados aos processos.
 */
class ProcessoService
{
    /**
     * Repositório de processos.
     *
     * @var ProcessoRepository
     */
    private $processoRepository;

    /**
     * Cria uma nova instância do serviço.
     *
     * @param ProcessoRepository $processoRepository O repositório de processos.
     */
    public function __construct(ProcessoRepository $processoRepository)
    {
        $this->processoRepository = $processoRepository;
    }

    /**
     * Valida os dados de entrada para criar um novo processo.
     *
     * @param array $filledFields Os dados a serem validados.
     * @return array|null A resposta JSON com erros de validação ou nulo se a validação for bem-sucedida.
     *
     * @throws Response Se houver um erro de validação não processável.
     */
    public function validateProcessInput($filledFields)
    {
        $rules = [
            'id_advogado' => 'required|integer',
            'id_cliente' => 'required|integer',
            'num_processo_sei' => 'required|string|max:255',
            'id_status' => 'required|integer',
            'observacao' => 'required|string|max:255',
        ];
        $customMessages = [
            '*' => [
                'required' => 'O campo :attribute é obrigatório',
                'max' => 'O campo :attribute deve conter no máximo :max caracteres',
            ],
        ];
        $validator = Validator::make($filledFields, $rules, $customMessages);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessage = 'Ocorreu o seguinte erro na operação: ' . implode(', ', $errors);
            return [
                'message' => $errorMessage,
                'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
            ];
        }
        return null;
    }

    /**
     * Cria um novo processo com os dados fornecidos.
     *
     * @param array $request Os dados do processo a serem criados.
     * @return array A mensagem de sucesso e o status da resposta.
     */
    public function createProcess($request)
    {
        $this->processoRepository->createProcess($request);
        return [
            'message' => 'Processo adicionado com sucesso!',
            'status' => Response::HTTP_CREATED,
        ];
    }

    /**
     * Valida o processo a ser excluído e, se válido, executa a exclusão.
     *
     * @param array $process Os dados do processo a ser validado e excluído.
     * @return array|null A resposta JSON com erros ou nulo se a operação for bem-sucedida.
     */
    public function validateProcessToDelete($process)
    {
        $processToDelete = $this->processoRepository->getProcessById($process);
        if (!$processToDelete) {
            return [
                'message' => 'O processo informado não foi encontrado',
                'status' => Response::HTTP_NOT_FOUND,
            ];
        }
        return $this->deleteProcess($processToDelete);
    }

    /**
     * Obtém a lista de processos com base no perfil do usuário solicitante.
     *
     * @param array $userRequester Os dados do usuário solicitante.
     * @return array A lista de processos com dados ocultados.
     */
    public function getIndex($userRequester)
    {
        $processos = $this->processoRepository->getIndex();
        if ($userRequester['id_perfil'] === 2) {
            $processos = $processos->filter(function ($processo) use ($userRequester) {
                return $processo->advogado->id_usuario === $userRequester['id_usuario'];
            });
        } elseif ($userRequester['id_perfil'] === 3) {
            $processos = $processos->filter(function ($processo) use ($userRequester) {
                return $processo->cliente->id_usuario === $userRequester['id_usuario'];
            });
        }
        $processos = $processos->map(function ($processo) {
            $processo->advogado->makeHidden(['senha', 'created_at', 'updated_at', 'deleted_at']);
            $processo->cliente->makeHidden(['senha', 'created_at', 'updated_at', 'deleted_at']);
            $processo->status->makeHidden(['created_at', 'updated_at', 'deleted_at']);
            return $processo;
        });
        return [
            'process' => $processos->values()->toArray(),
            'status' => Response::HTTP_OK
        ];
    }

    /**
     * Atualiza um processo existente com os dados fornecidos.
     *
     * @param array $request Os dados do processo a serem atualizados.
     * @return array|null A mensagem de sucesso e o status da resposta.
     */
    public function updateProcess($request)
    {
        $processToUpdate = $this->processoRepository->getProcessById($request);
        if (!$processToUpdate) {
            return [
                'message' => "O processo informado não foi encontrado",
                'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
            ];
        }
        $this->processoRepository->updateProcess($request, $processToUpdate);
        return null;
    }

    /**
     * Exclui um processo existente.
     *
     * @param mixed $process O processo a ser excluído.
     * @return array|null A mensagem de sucesso e o status da resposta.
     */
    public function deleteProcess($process)
    {
        $this->processoRepository->deleteProcess($process);
        return null;
    }
}
