<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historicocs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            
            $table->string('codigo')->nullable();
            $table->date('fecha_aprobacion')->nullable();
            $table->integer('horas_aprobadas')->nullable();
            $table->longText('estado_tarea',)->nullable();
            $table->longText('prestador')->nullable();

            $table->longText('empresa')->nullable();
            $table->longText('tarea')->nullable();
            $table->longText('clasificacion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historicocs');
    }
};
