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
        Schema::create('municipios', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nombre');

        });

        Schema::table('orden_compras', function (Blueprint $table) {
            $table->unsignedBigInteger('empresa_id');
            $table->foreign('empresa_id')
                    ->references('id')
                    ->on('empresas')
                    ->onDelete('restrict');

            $table->unsignedBigInteger('tarea_id');
            $table->foreign('tarea_id')
                    ->references('id')
                    ->on('tareas')
                    ->onDelete('restrict');

            $table->unsignedBigInteger('clasificacion_id');

            $table->foreign('clasificacion_id')
                    ->references('id')
                    ->on('clasificacions')
                    ->onDelete('restrict');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('rol_id');
            $table->foreign('rol_id')
                    ->references('id')
                    ->on('roles')
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
        Schema::dropIfExists('municipios');
    }
};
