<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        DB::table('tab_usuarios')->insert([
            [
                'nome' => 'Kleber Alves',
                'cpf' => '12345678901',
                'senha' => bcrypt('senha123'),
                'email' => 'kleber@gmail.com',
                'dat_nasc' => '1999-07-27',
                'endereco' => 'Rua Exemplo, 123',
                'id_perfil' => 1,
                'created_at' => $now,
            ],
            [
                'nome' => 'Edilson Pereira',
                'cpf' => '14725836900',
                'senha' => bcrypt('senha789'),
                'email' => 'Pereira@bol.com',
                'dat_nasc' => '1981-06-19',
                'endereco' => 'Fortaleza, Ceará',
                'id_perfil' => 2,
                'created_at' => $now,
            ],
            [
                'nome' => 'Maria Santos',
                'cpf' => '98765432101',
                'senha' => bcrypt('senha456'),
                'email' => 'maria@yahoo.com',
                'dat_nasc' => '1995-05-10',
                'endereco' => 'Avenida Teste, 456',
                'id_perfil' => 3,
                'created_at' => $now,
            ],
        ]);
    }
}
