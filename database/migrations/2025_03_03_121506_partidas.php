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
        Schema::create('partidas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('casa_time_id');
            $table->unsignedBigInteger('fora_time_id');
            $table->date('data_do_jogo');
            $table->string('resultado');
            $table->time('horario_inicio');
            $table->timestamps();
            $table->foreign('casa_time_id')->references('id')->on('times');
            $table->foreign('fora_time_id')->references('id')->on('times');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partidas');
    }
};
