<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Executa as operações de seeding no banco de dados.
     *
     * @return void
     */
    public function run(): void
    {
        $statusSeed = [
            ['status' => 'Aguardando Julgamento', 'descricao' => 'O processo está aguardando julgamento.', 'created_at' => now()],
            ['status' => 'Em Andamento', 'descricao' => 'O processo está em andamento.', 'created_at' => now()],
            ['status' => 'Em Recurso', 'descricao' => 'O processo está em fase de recurso.', 'created_at' => now()],
            ['status' => 'Concluído', 'descricao' => 'O processo foi concluído.', 'created_at' => now()],
            ['status' => 'Arquivado', 'descricao' => 'O processo foi arquivado.', 'created_at' => now()],
            ['status' => 'Suspenso', 'descricao' => 'O processo está suspenso temporariamente.', 'created_at' => now()],
            ['status' => 'Cancelado', 'descricao' => 'O processo foi cancelado.', 'created_at' => now()],
            ['status' => 'Em Mediação', 'descricao' => 'O processo está em mediação.', 'created_at' => now()],
            ['status' => 'Em Arbitragem', 'descricao' => 'O processo está em arbitragem.', 'created_at' => now()],
            ['status' => 'Pendente de Notificação', 'descricao' => 'O processo está pendente de notificação.', 'created_at' => now()],
        ];
        foreach ($statusSeed as $status) {
            DB::table('tab_status')->insert($status);
        }
    }
}
