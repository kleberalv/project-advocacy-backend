<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Executa as migrações.
     */
    public function up(): void
    {
        Schema::create('tab_tipo_perfil', function (Blueprint $table) {
            $table->id('id_tipo_perfil');
            $table->string('nome_perfil');
            $table->timestamps();
            $table->softDeletes('deleted_at');
        });
    }

    /**
     * Reverte as migrações.
     */
    public function down(): void
    {
        // Remove a tabela 'tab_tipo_perfil' se ela existir
        Schema::dropIfExists('tab_tipo_perfil');
    }
};
