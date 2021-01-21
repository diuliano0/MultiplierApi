<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterarUsuarioImagemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('core.users', function (Blueprint $table) {
			$table->string('img')->nullable();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		if (Schema::hasColumn('core.users', 'img')) {
			Schema::table('core.users', function (Blueprint $table) {
				$table->dropColumn('img');
			});
		}
    }
}
