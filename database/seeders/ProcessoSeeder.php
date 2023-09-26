<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

class ProcessoSeeder extends Seeder
{
    /**
     * Executa as operações de seeding no banco de dados.
     *
     * @return void
     */
    public function run(): void
    {
        $now = Carbon::now();
        $faker = Faker::create();
        for ($i = 0; $i < 5; $i++) {
            $advogadoId = rand(2, 4);
            $clienteId = rand(5, 7);
            DB::table('tab_processo')->insert([
                'id_advogado' => $advogadoId,
                'id_cliente' => $clienteId,
                'num_processo_sei' => 'SEI' . rand(100000, 999999),
                'id_status' => rand(1, 10),
                'observacao' => $faker->sentence,
                'created_at' => $now,
            ]);
        }
    }
}
