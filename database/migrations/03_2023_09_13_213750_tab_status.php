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
        Schema::create('tab_status', function (Blueprint $table) {
            $table->id('id_status');
            $table->string('status');
            $table->text('descricao')->nullable();
            $table->timestamps();
            $table->softDeletes('deleted_at');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tab_status');
    }
};
