<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRotaAcessosTable extends Migration
{
	use \Modules\Core\Traits\FiliaisMigrationTrait;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core.rota_acessos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->nullable();
            $table->string('titulo');
            $table->string('rota');
            $table->string('icon')->nullable();
            $table->boolean('disabled')->default(false);
            $table->boolean('is_menu')->default(false);
            $table->string('ambiente')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('core.rota_acessos');
    }
}
