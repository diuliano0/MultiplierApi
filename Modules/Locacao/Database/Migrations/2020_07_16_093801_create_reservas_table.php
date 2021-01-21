<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservasTable extends Migration
{
    use \Modules\Core\Traits\FiliaisMigrationTrait;
    public function up()
    {
        Schema::create('locacao.reservas', function (Blueprint $table) {
            $table->bigIncrements('id');
            self::insertFilialForeng($table);
            $table->integer('locador_id')->unsigned()->nullable()->index();
            $table->foreign('locador_id')->references('id')->on('locacao.locadores');
            $table->double('valor')->default(0.0);
            $table->json('snapshot')->nullable();
            $table->integer('status');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('locacao.reservas');
    }
}
