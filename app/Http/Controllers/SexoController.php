<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Response;
use App\Services\SexoService;

/**
 * Controlador para gerenciamento de sexos.
 */
class SexoController extends Controller
{
    /**
     * Serviço de gerenciamento de sexos.
     *
     * @var SexoService
     */
    private $sexoService;

    /**
     * Cria uma nova instância do controlador.
     *
     * @param SexoService $sexoService O serviço de gerenciamento de sexos.
     */
    public function __construct(SexoService $sexoService)
    {
        $this->sexoService = $sexoService;
    }

    /**
     * Obtém a lista de sexos.
     *
     * @return \Illuminate\Http\JsonResponse A resposta JSON contendo a lista de sexos e o código de status HTTP correspondente.
     *
     * @throws \Exception Se ocorrer um erro interno no servidor.
     */
    public function index()
    {
        try {
            $sexos = $this->sexoService->getIndex();
            return response()->json([
                'sexos' => $sexos['sexos'],
            ], $sexos['status']);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
