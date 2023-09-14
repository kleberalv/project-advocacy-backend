<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
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
        DB::statement('ALTER TABLE tab_processo ADD CHECK (id_advogado = 2)');
        DB::statement('ALTER TABLE tab_processo ADD CHECK (id_cliente = 3)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tab_processo');
    }
};
