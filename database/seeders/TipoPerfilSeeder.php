<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TipoPerfilSeeder extends Seeder
{
    /**
     * Executa as operações de seeding no banco de dados.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        DB::table('tab_tipo_perfil')->insert([
            [
                'nome_perfil' => 'Admin',
                'created_at' => $now,
            ],
            [
                'nome_perfil' => 'Advogado',
                'created_at' => $now,
            ],
            [
                'nome_perfil' => 'Cliente',
                'created_at' => $now,
            ],
        ]);
    }
}
