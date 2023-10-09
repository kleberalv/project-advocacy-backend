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
        Schema::create('tab_permissoes', function (Blueprint $table) {
            $table->id();
            $table->string('resource');
            $table->string('action');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverte as migrações.
     */
    public function down()
    {
        Schema::dropIfExists('tab_permissoes');
    }
};
