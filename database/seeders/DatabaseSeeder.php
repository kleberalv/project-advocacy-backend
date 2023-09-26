<?php

use Illuminate\Database\Seeder;
use Database\Seeders\UsuariosSeeder;
use Database\Seeders\TipoPerfilSeeder;
use Database\Seeders\StatusSeeder;
use Database\Seeders\ProcessoSeeder;

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
        $this->call(UsuariosSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(ProcessoSeeder::class);
    }
}
