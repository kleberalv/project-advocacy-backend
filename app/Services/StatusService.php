<?php

namespace App\Services;

use App\Repositories\StatusRepository;
use Illuminate\Http\Response;

class StatusService
{
    /**
     * Repositório de status.
     *
     * @var StatusRepository
     */
    private $statusRepository;

    /**
     * Cria uma nova instância do serviço.
     *
     * @param StatusRepository $statusRepository O repositório de status.
     */
    public function __construct(StatusRepository $statusRepository)
    {
        $this->statusRepository = $statusRepository;
    }

    /**
     * Obtém a lista de status.
     *
     * @return array A lista de status com o código de resposta HTTP.
     */
    public function getIndex()
    {
        $status = $this->statusRepository->getIndex();
        return [
            'statusProcess' => $status,
            'status' => Response::HTTP_OK
        ];
    }
}
