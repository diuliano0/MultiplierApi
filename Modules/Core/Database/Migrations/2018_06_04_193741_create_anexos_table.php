<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnexosTable extends Migration
{
	use \Modules\Core\Traits\FiliaisMigrationTrait;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core.anexos', function (Blueprint $table) {
            $table->increments('id');
			$table->string('nome')->nullable();
			$table->string('alias')->nullable();
			$table->string('extensao')->nullable();
			$table->string('diretorio')->nullable();
			$table->integer('tamanho')->nullable();
			$table->integer('anexotable_id')->nullable();
			$table->string('anexotable_type')->nullable();
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
        Schema::dropIfExists('core.anexos');
    }
}
