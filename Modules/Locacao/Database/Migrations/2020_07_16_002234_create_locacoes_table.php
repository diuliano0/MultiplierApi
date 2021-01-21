<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocacoesTable extends Migration
{
    use \Modules\Core\Traits\FiliaisMigrationTrait;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locacao.locacoes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome');
            $table->integer('categoria_locacao_id')->unsigned()->nullable()->index();
            $table->foreign('categoria_locacao_id')->references('id')->on('locacao.categoria_locacoes');
            $table->integer('capacidade');
            $table->integer('status');
            $table->text('descricao')->nullable();
            $table->double('valor_locacao')->nullable()->default(0.0);
            $table->double('custo_operacional')->nullable()->default(0.0);
            $table->string('url_360')->nullable();
            $table->timestamps();
            self::insertFilialForeng($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locacao.locacoes');
    }
}
