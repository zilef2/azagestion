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
        Schema::create('reportes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('horas')->default(0);
            $table->float('aprobadas')->default(0);

            $table->dateTime('fecha_reporte')->nullable();
            $table->date('fecha_ejecucion')->nullable();
            $table->string('observaciones')->nullable();
            $table->boolean('requiere_transporte')->nullable();

            $table->string('justificacion')->nullable();
            $table->string('novedad')->nullable();
            $table->string('photo')->nullable();
            
            $table->integer('aprobado')->default(0);
            $table->string('adjunto')->nullable();
            $table->integer('bancohoras')->nullable();

            $table->unsignedBigInteger('orden_compra_id');
            $table->foreign('orden_compra_id')
                    ->references('id')
                    ->on('orden_compras')
                    ->onDelete('restrict');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('restrict');

            $table->unsignedBigInteger('municipio_id')->nullable();
            $table->foreign('municipio_id')
                    ->references('id')
                    ->on('municipios')
                    ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reportes');
    }
};
