<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrupoRotaAcessosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core.grupo_rota_acessos', function (Blueprint $table) {
            $table->increments('id');

			$table->integer('grupo_id')->unsigned()->index();
			$table->foreign('grupo_id')->references('id')->on('core.grupos')->onDelete('cascade');

			$table->integer('rota_acesso_id')->unsigned()->index();
			$table->foreign('rota_acesso_id')->references('id')->on('core.rota_acessos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('core.grupo_rota_acessos');
    }
}
