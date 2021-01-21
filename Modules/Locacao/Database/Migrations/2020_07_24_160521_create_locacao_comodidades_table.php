<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocacaoComodidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locacao.locacao_comodidades', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('locacao_id')->unsigned()->nullable()->index();
            $table->foreign('locacao_id')->references('id')->on('locacao.locacoes');

            $table->integer('comodidade_id')->unsigned()->nullable()->index();
            $table->foreign('comodidade_id')->references('id')->on('locacao.comodidades');

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
        Schema::dropIfExists('locacao.locacao_comodidades');
    }
}
