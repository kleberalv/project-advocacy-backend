<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissoesSeeder extends Seeder
{
    public function run()
    {
        DB::table('tab_permissoes')->insert([
            ['resource' => 'users.store', 'action' => 'POST'],
            ['resource' => 'users.index', 'action' => 'GET'],
            ['resource' => 'users.update', 'action' => 'PUT'],
            ['resource' => 'users.destroy', 'action' => 'DELETE'],
            ['resource' => 'profiles.store', 'action' => 'POST'],
            ['resource' => 'profiles.index', 'action' => 'GET'],
            ['resource' => 'profiles.update', 'action' => 'PUT'],
            ['resource' => 'profiles.destroy', 'action' => 'DELETE'],
            ['resource' => 'status.store', 'action' => 'POST'],
            ['resource' => 'status.index', 'action' => 'GET'],
            ['resource' => 'status.update', 'action' => 'PUT'],
            ['resource' => 'status.destroy', 'action' => 'DELETE'],
            ['resource' => 'sexos.store', 'action' => 'POST'],
            ['resource' => 'sexos.index', 'action' => 'GET'],
            ['resource' => 'sexos.update', 'action' => 'PUT'],
            ['resource' => 'sexos.destroy', 'action' => 'DELETE'],
            ['resource' => 'process.store', 'action' => 'POST'],
            ['resource' => 'process.index', 'action' => 'GET'],
            ['resource' => 'process.update', 'action' => 'PUT'],
            ['resource' => 'process.destroy', 'action' => 'DELETE'],
            ['resource' => 'lawyer.index', 'action' => 'GET'],
            ['resource' => 'client.index', 'action' => 'GET'],
            ['resource' => 'me.index', 'action' => 'GET'],
            ['resource' => 'me.update', 'action' => 'PUT'],
        ]);
    }
}
