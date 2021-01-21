<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableGrupo extends Migration
{
	use \Modules\Core\Traits\FiliaisMigrationTrait;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core.grupos', function (Blueprint $table) {
            $table->increments('id');
			$table->string('nome')->unique();
			$table->text('descricao')->nullable();
			$table->integer('status')->default(1);
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
        Schema::dropIfExists('core.grupos');
    }
}
