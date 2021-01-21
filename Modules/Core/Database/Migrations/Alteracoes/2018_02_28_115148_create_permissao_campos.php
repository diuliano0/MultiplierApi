<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissaoCampos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('seguranca.tb_permissao', function (Blueprint $table) {
			$table->string('rotina_modulo')->nullable();
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
		if (Schema::hasColumn('seguranca.tb_permissao', 'device_uuid')) {
			Schema::table('seguranca.tb_permissao', function (Blueprint $table) {
				$table->dropColumn('rotina_modulo');
				$table->dropTimestamps();
			});
		}
    }
}
