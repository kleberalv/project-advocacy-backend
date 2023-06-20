<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Database\Seeders\UsuariosSeeder;
use Database\Seeders\TipoPerfilSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TipoPerfilSeeder::class);
        $this->call(UsuariosSeeder::class);
    }
}
