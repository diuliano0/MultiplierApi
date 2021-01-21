<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHorariosTable extends Migration
{
    use \Modules\Core\Traits\FiliaisMigrationTrait;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locacao.horarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            self::insertFilialForeng($table);
            $table->integer('locacao_id')->unsigned()->nullable()->index();
            $table->foreign('locacao_id')->references('id')->on('locacao.locacoes');
            $table->timestamp('dth_inicio');
            $table->timestamp('dth_fim');
            $table->boolean('hr_ativo_app')->nullable()->default(true);
            $table->double('valor')->nullable()->default(0.0);
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
        Schema::dropIfExists('locacao.horarios');
    }
}
