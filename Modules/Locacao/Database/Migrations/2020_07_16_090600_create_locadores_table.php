<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locacao.locadores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->foreign('user_id')->references('id')->on('core.users');
            $table->integer('pessoa_id')->nullable()->unsigned()->index();
            $table->foreign('pessoa_id')->references('id')->on('core.pessoas');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('locacao.locadores');
    }
}
