<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UsuariosSeeder;
use Database\Seeders\TipoPerfilSeeder;
use Database\Seeders\StatusSeeder;
use Database\Seeders\ProcessoSeeder;
use Database\Seeders\SexoSeeder;
use Database\Seeders\PermissoesSeeder;
use Database\Seeders\FuncoesPermissoesSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Executa as operações de seeding no banco de dados.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            TipoPerfilSeeder::class,
            SexoSeeder::class,
            UsuariosSeeder::class,
            StatusSeeder::class,
            ProcessoSeeder::class,
            PermissoesSeeder::class,
            FuncoesPermissoesSeeder::class,
        ]);
    }
}
