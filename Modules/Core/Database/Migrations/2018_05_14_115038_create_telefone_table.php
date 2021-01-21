<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTelefoneTable extends Migration
{
	use \Modules\Core\Traits\FiliaisMigrationTrait;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core.telefones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tipo_telefone');
            $table->string('ddd');
            $table->string('numero');
            $table->string('observacao')->nullable();
			$table->integer('pessoa_id')->unsigned()->nullable()->index();
			$table->foreign('pessoa_id')->references('id')->on('core.pessoas');
			self::insertFilialForeng($table);
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
        Schema::dropIfExists('core.telefones');
    }
}
