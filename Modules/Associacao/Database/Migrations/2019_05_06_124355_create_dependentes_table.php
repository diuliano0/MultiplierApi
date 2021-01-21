<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDependentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('associacao.dependentes', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('trabalhador_id')->nullable()->unsigned()->index();
			$table->foreign('trabalhador_id')->references('id')->on('associacao.trabalhadores');
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
        Schema::dropIfExists('associacao.dependentes');
    }
}
