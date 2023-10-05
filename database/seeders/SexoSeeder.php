<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SexoSeeder extends Seeder
{
    /**
     * Executa as operações de seeding no banco de dados.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        DB::table('tab_sexo')->insert([
            ['nome_sexo' => 'Masculino', 'created_at' => $now],
            ['nome_sexo' => 'Feminino', 'created_at' => $now],
            ['nome_sexo' => 'Homem Trans', 'created_at' => $now],
            ['nome_sexo' => 'Mulher Trans', 'created_at' => $now],
            ['nome_sexo' => 'Agênero', 'created_at' => $now],
            ['nome_sexo' => 'Não Binário', 'created_at' => $now],
            ['nome_sexo' => 'Outros', 'created_at' => $now],
        ]);
    }
}
