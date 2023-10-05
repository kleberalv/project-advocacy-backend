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
        Schema::create('tab_sexo', function (Blueprint $table) {
            $table->id('id_sexo');
            $table->string('nome_sexo');
            $table->timestamps();
            $table->softDeletes('deleted_at');
        });
    }

    /**
     * Reverte as migrações.
     */
    public function down(): void
    {
        Schema::dropIfExists('tab_sexo');
    }
};
