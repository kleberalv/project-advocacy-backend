<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Response;
use App\Services\StatusService;

class StatusController extends Controller
{
    /**
     * Serviço de gerenciamento de status.
     *
     * @var StatusService
     */
    private $statusService;

    /**
     * Cria uma nova instância do controlador.
     *
     * @param StatusService $statusService O serviço de gerenciamento de status.
     */
    public function __construct(StatusService $statusService)
    {
        $this->statusService = $statusService;
    }

    /**
     * Obtém a lista de status.
     *
     * @return \Illuminate\Http\JsonResponse A resposta JSON contendo a lista de status e o código de status HTTP correspondente.
     *
     * @throws \Exception Se ocorrer um erro interno no servidor.
     */
    public function index()
    {
        try {
            $status = $this->statusService->getIndex();
            return response()->json([
                'status' => $status['statusProcess'],
            ], $status['status']);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
