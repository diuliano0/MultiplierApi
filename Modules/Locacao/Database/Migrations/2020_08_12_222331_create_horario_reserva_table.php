<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHorarioReservaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locacao.horario_reservas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('reserva_id')->unsigned()->nullable()->index();
            $table->foreign('reserva_id')->references('id')->on('locacao.reservas');
            $table->integer('horario_id')->unsigned()->nullable()->index();
            $table->foreign('horario_id')->references('id')->on('locacao.horarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('horario_reserva');
    }
}
