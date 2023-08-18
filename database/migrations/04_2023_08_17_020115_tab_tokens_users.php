<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tab_tokens_users', function (Blueprint $table) {
            $table->id('id_token');
            $table->string('tokenable_type');
            $table->unsignedBigInteger('tokenable_id_usuario');
            $table->string('name_token');
            $table->string('token', 512)->unique();
            $table->unsignedBigInteger('id_perfil_permissions');
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_perfil_permissions')->references('id_tipo_perfil')->on('tab_tipo_perfil');
            $table->foreign('tokenable_id_usuario')->references('id_usuario')->on('tab_usuarios');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tab_tokens_users');
    }
};
