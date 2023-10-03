<?php

namespace App\Repositories;

use App\Models\Status;

class StatusRepository
{
    /**
     * Retorna a lista de status.
     *
     * @return \Illuminate\Database\Eloquent\Collection A lista de status ativos.
     */
    public function getIndex()
    {
        return Status::whereNull('deleted_at')->get();
    }
}
