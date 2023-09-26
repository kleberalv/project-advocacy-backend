<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Executa as migrações.
     */
    public function up(): void
    {
        Schema::create('tab_processo', function (Blueprint $table) {
            $table->id('id_processo');
            $table->unsignedBigInteger('id_advogado');
            $table->foreign('id_advogado')->references('id_usuario')->on('tab_usuarios');
            $table->unsignedBigInteger('id_cliente');
            $table->foreign('id_cliente')->references('id_usuario')->on('tab_usuarios');
            $table->string('num_processo_sei');
            $table->unsignedBigInteger('id_status')->nullable();
            $table->foreign('id_status')->references('id_status')->on('tab_status');
            $table->text('observacao')->nullable();
            $table->timestamps();
            $table->softDeletes('deleted_at');
        });
    }

    /**
     * Reverte as migrações.
     */
    public function down(): void
    {
        Schema::dropIfExists('tab_processo');
    }
};
