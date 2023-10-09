<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Executa as migrações.
     */
    public function up()
    {
        Schema::create('tab_funcoes_permissoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_perfil');
            $table->unsignedBigInteger('permissao_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_perfil')->references('id_tipo_perfil')->on('tab_tipo_perfil')->onDelete('cascade');
            $table->foreign('permissao_id')->references('id')->on('tab_permissoes')->onDelete('cascade');
        });
    }

    /**
     * Reverte as migrações.
     */
    public function down()
    {
        Schema::dropIfExists('tab_funcoes_permissoes');
    }
};
