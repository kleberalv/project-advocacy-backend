<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
            $table->unsignedBigInteger('id_usuario');
            $table->string('num_processo_sei');
            $table->timestamps();
            $table->softDeletes('deleted_at');

            $table->foreign('id_usuario')->references('id_usuario')->on('tab_usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tab_processo');
    }
};