<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableFilialValorAcrescimo extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('core.filiais', function (Blueprint $table) {
			$table->double('valor_acrescimo')->nullable()->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('core.filiais', function (Blueprint $table) {
			$table->dropColumn('valor_acrescimo');
		});
	}
}
