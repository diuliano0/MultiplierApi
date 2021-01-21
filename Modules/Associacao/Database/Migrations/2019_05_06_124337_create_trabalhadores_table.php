<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrabalhadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		\DB::statement('CREATE SCHEMA associacao AUTHORIZATION postgres;');
        Schema::create('associacao.trabalhadores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('matricula');
            $table->integer('funcao');
			$table->integer('pessoa_id')->nullable()->unsigned()->index();
			$table->foreign('pessoa_id')->references('id')->on('core.pessoas');
			$table->integer('user_id')->nullable()->unsigned()->index();
			$table->foreign('user_id')->references('id')->on('core.users');

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
        Schema::dropIfExists('associacao.trabalhadores');
    }
}
