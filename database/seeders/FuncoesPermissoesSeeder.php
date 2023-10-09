<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FuncoesPermissoesSeeder extends Seeder
{
    /**
     * Executa as operações de seeding no banco de dados.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tab_funcoes_permissoes')->insert([
            ['id_perfil' => 1, 'permissao_id' => 1],
            ['id_perfil' => 1, 'permissao_id' => 2],
            ['id_perfil' => 1, 'permissao_id' => 3],
            ['id_perfil' => 1, 'permissao_id' => 4],
            ['id_perfil' => 1, 'permissao_id' => 5],
            ['id_perfil' => 1, 'permissao_id' => 6],
            ['id_perfil' => 1, 'permissao_id' => 7],
            ['id_perfil' => 1, 'permissao_id' => 8],
            ['id_perfil' => 1, 'permissao_id' => 9],
            ['id_perfil' => 1, 'permissao_id' => 10],
            ['id_perfil' => 1, 'permissao_id' => 11],
            ['id_perfil' => 1, 'permissao_id' => 12],
            ['id_perfil' => 1, 'permissao_id' => 13],
            ['id_perfil' => 1, 'permissao_id' => 14],
            ['id_perfil' => 1, 'permissao_id' => 15],
            ['id_perfil' => 1, 'permissao_id' => 16],
            ['id_perfil' => 1, 'permissao_id' => 17],
            ['id_perfil' => 1, 'permissao_id' => 18],
            ['id_perfil' => 1, 'permissao_id' => 19],
            ['id_perfil' => 1, 'permissao_id' => 20],
            ['id_perfil' => 1, 'permissao_id' => 21],
            ['id_perfil' => 1, 'permissao_id' => 22],
            ['id_perfil' => 1, 'permissao_id' => 23],
            ['id_perfil' => 1, 'permissao_id' => 24],

            ['id_perfil' => 2, 'permissao_id' => 2],
            ['id_perfil' => 2, 'permissao_id' => 10],
            ['id_perfil' => 2, 'permissao_id' => 14],
            ['id_perfil' => 2, 'permissao_id' => 17],
            ['id_perfil' => 2, 'permissao_id' => 18],
            ['id_perfil' => 2, 'permissao_id' => 19],
            ['id_perfil' => 2, 'permissao_id' => 20],
            ['id_perfil' => 2, 'permissao_id' => 21],
            ['id_perfil' => 2, 'permissao_id' => 22],
            ['id_perfil' => 2, 'permissao_id' => 23],
            ['id_perfil' => 2, 'permissao_id' => 24],

            ['id_perfil' => 3, 'permissao_id' => 14],
            ['id_perfil' => 3, 'permissao_id' => 18],
            ['id_perfil' => 3, 'permissao_id' => 23],
            ['id_perfil' => 3, 'permissao_id' => 24],
        ]);
    }
}
