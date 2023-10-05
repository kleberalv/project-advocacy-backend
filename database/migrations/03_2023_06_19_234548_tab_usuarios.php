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
        Schema::create('tab_usuarios', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->unsignedBigInteger('id_perfil');
            $table->unsignedBigInteger('id_sexo');
            $table->string('nome');
            $table->string('cpf')->unique();
            $table->string('senha');
            $table->string('email');
            $table->date('dat_nasc');
            $table->string('endereco');
            $table->timestamps();
            $table->softDeletes('deleted_at');

            $table->foreign('id_perfil')->references('id_tipo_perfil')->on('tab_tipo_perfil');
            $table->foreign('id_sexo')->references('id_sexo')->on('tab_sexo');
        });
    }

    /**
     * Reverte as migrações.
     */
    public function down(): void
    {
        Schema::dropIfExists('tab_usuarios');
    }
};
