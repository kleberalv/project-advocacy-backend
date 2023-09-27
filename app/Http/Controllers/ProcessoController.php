<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProcessoService;
use App\Http\Controllers\AuthController;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Controlador para gerenciamento de processos.
 */
class ProcessoController extends Controller
{
    /**
     * Instância do serviço de processos.
     *
     * @var ProcessoService
     */
    private $processoService;

    /**
     * Instância do controlador de autenticação.
     *
     * @var AuthController
     */
    private $authController;

    /**
     * Cria uma nova instância do controlador.
     *
     * @param ProcessoService $processoService O serviço de processos.
     * @param AuthController $authController O controlador de autenticação.
     */
    public function __construct(ProcessoService $processoService, AuthController $authController)
    {
        $this->processoService = $processoService;
        $this->authController = $authController;
    }

    /**
     * Armazena um novo processo no sistema.
     *
     * @param Request $request A requisição HTTP contendo os dados do novo processo.
     * @return \Illuminate\Http\JsonResponse A resposta JSON indicando o sucesso da operação ou erros de validação.
     *
     * @throws Exception Se houver um erro interno durante o processamento.
     */
    public function store(Request $request)
    {
        try {
            $validationResponse = $this->processoService->validateProcessInput($request->all());
            if ($validationResponse !== null) {
                return $validationResponse;
            }
            $process = $this->processoService->createProcess($request->all());
            $process->unsetRelation('advogado');
            $process->unsetRelation('cliente');
            return response()->json([
                'message' => 'Processo adicionado com sucesso!',
                'processo' => $process,
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Obtém o perfil do usuário solicitante.
     *
     * @return array O perfil do usuário solicitante.
     *
     * @throws Exception Se houver um erro ao recuperar o perfil.
     */
    public function getIdPerfilRequester()
    {
        try {
            $userData = $this->authController->me();
            return $userData->original["user"][0];
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Retorna a lista de processos.
     *
     * @return \Illuminate\Http\JsonResponse A resposta JSON contendo a lista de processos.
     *
     * @throws Exception Se houver um erro ao recuperar a lista de processos.
     */
    public function index()
    {
        try {
            $userRequester = $this->getIdPerfilRequester();
            $processos = $this->processoService->getIndex($userRequester);
            return response()->json([
                'processos' => $processos,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Atualiza um processo existente no sistema.
     *
     * @param Request $request A requisição HTTP contendo os dados do processo a ser atualizado.
     * @return \Illuminate\Http\JsonResponse A resposta JSON indicando o sucesso da operação ou erros de validação.
     *
     * @throws Exception Se houver um erro interno durante o processamento.
     */
    public function update(Request $request)
    {
        try {
            $validationResponse = $this->processoService->validateProcessInput($request->all());
            if ($validationResponse !== null) {
                return $validationResponse;
            }
            $process = $this->processoService->updateProcess($request->all());
            if ($process instanceof JsonResponse && $process->getStatusCode() !== Response::HTTP_OK) {
                return $process;
            }
            $process->unsetRelation('advogado');
            $process->unsetRelation('cliente');
            return response()->json([
                'message' => 'Processo atualizado com sucesso!',
                'processo' => $process,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Exclui um processo existente do sistema.
     *
     * @param Request $request A requisição HTTP contendo os dados do processo a ser excluído.
     * @return \Illuminate\Http\JsonResponse A resposta JSON indicando o sucesso da operação ou erros de validação.
     *
     * @throws Exception Se houver um erro interno durante o processamento.
     */
    public function destroy(Request $request)
    {
        try {
            $process = $this->processoService->validateProcessToDelete($request->all());
            if ($process instanceof JsonResponse && $process->getStatusCode() !== Response::HTTP_OK) {
                return $process;
            }
            return response()->json([
                'message' => 'Processo excluído com sucesso!',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
