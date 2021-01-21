<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePermissao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core.permissaos', function (Blueprint $table) {
            $table->increments('id');
			$table->string('rotina');
			$table->string('modulo');
			$table->integer('grupo_id')->unsigned()->nullable()->index();
			$table->foreign('grupo_id')->references('id')->on('grupos');
			$table->string('rotina_modulo');
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
        Schema::dropIfExists('core.permissaos');
    }
}
