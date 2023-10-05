<?php

namespace App\Services;

use App\Repositories\SexoRepository;
use Illuminate\Http\Response;

/**
 * Serviço para gerenciamento de sexos.
 */
class SexoService
{
    /**
     * Repositório de sexos.
     *
     * @var SexoRepository
     */
    private $sexoRepository;

    /**
     * Cria uma nova instância do serviço.
     *
     * @param SexoRepository $sexoRepository O repositório de sexos.
     */
    public function __construct(SexoRepository $sexoRepository)
    {
        $this->sexoRepository = $sexoRepository;
    }

    /**
     * Obtém a lista de sexos.
     *
     * @return array A lista de sexos com o código de resposta HTTP.
     */
    public function getIndex()
    {
        $sexos = $this->sexoRepository->getIndex();
        return [
            'sexos' => $sexos,
            'status' => Response::HTTP_OK
        ];
    }
}
