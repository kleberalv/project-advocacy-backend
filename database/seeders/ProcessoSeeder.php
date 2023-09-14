<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProcessoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tab_processo')->insert([
            'id_advogado' => 2,
            'id_cliente' => 3,
            'num_processo_sei' => 'SEI123456',
            'id_status' => 1,
            'observacao' => 'O processo encontra-se em andamento',
            'created_at' => now(),
        ]);
    }
}
