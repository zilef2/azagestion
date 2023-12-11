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
        Schema::create('orden_compras', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('codigo')->unique();
            $table->date('fecha')->nullable();
            // $table->integer('horas')->nullable();
            $table->float('horasaprobadas')->nullable();
            $table->float('horasaprobadasAsignador')->nullable();
            $table->float('horasdisponibles')->nullable();
            $table->integer('estado_tarea')->nullable();//0: pendiente | 1: ejecutada

           //The relationship of this table are coded in create_municipios_table.php
        });
        //aparecer en el descargable y en los formulario de correccion
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orden_compras');
    }
};
