<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaturasTable extends Migration
{
    use \Modules\Core\Traits\FiliaisMigrationTrait;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locacao.faturas', function (Blueprint $table) {
            $table->increments('id');
            self::insertFilialForeng($table);
			$table->string('codigo');
			$table->integer('meio_pagamento');
			$table->double('valor');
			$table->integer('reserva_id')->unsigned()->nullable()->index();
			$table->foreign('reserva_id')->references('id')->on('locacao.reservas');
			$table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locacao.faturas');
    }
}
