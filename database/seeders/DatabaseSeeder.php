<?php

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
    public function run()
    {
        $this->call(TipoPerfilSeeder::class);
        $this->call(SexoSeeder::class);
        $this->call(UsuariosSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(ProcessoSeeder::class);
        $this->call(PermissoesSeeder::class);
        $this->call(FuncoesPermissoesSeeder::class);
    }
}
