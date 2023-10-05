<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

class UsuariosSeeder extends Seeder
{
    /**
     * Executa as operações de seeding no banco de dados.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        $faker = Faker::create();
        $faker->addProvider(new \Faker\Provider\pt_BR\Person($faker));
        DB::table('tab_usuarios')->insert([
            'nome' => 'Kleber Alves',
            'cpf' => '12345678901',
            'senha' => bcrypt('senha123'),
            'email' => 'kleber@gmail.com',
            'dat_nasc' => '1999-07-27',
            'endereco' => 'Rua Exemplo, 123',
            'id_perfil' => 1,
            'id_sexo' => 1,
            'created_at' => $now,
        ]);
        for ($i = 0; $i < 3; $i++) {
            DB::table('tab_usuarios')->insert([
                'nome' => $faker->name,
                'cpf' => $faker->cpf(false),
                'senha' => bcrypt('senha123'),
                'email' => $faker->unique()->safeEmail,
                'dat_nasc' => $faker->date('Y-m-d', '2000-01-01'),
                'endereco' => $faker->address,
                'id_perfil' => 2,
                'id_sexo' => rand(1, 7),
                'created_at' => $now,
            ]);
        }
        for ($i = 0; $i < 3; $i++) {
            DB::table('tab_usuarios')->insert([
                'nome' => $faker->name,
                'cpf' => $faker->cpf(false),
                'senha' => bcrypt('senha123'),
                'email' => $faker->unique()->safeEmail,
                'dat_nasc' => $faker->date('Y-m-d', '2000-01-01'),
                'endereco' => $faker->address,
                'id_perfil' => 3,
                'id_sexo' => rand(1, 7),
                'created_at' => $now,
            ]);
        }
    }
}
