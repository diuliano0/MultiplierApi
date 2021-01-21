<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulosAtivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core.modulos_ativos', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('filial_id')->unsigned()->index();
			$table->foreign('filial_id')->references('id')->on('core.filiais')->onDelete('cascade');
			$table->integer('modulo');
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
        Schema::dropIfExists('modulos_ativos');
    }
}
