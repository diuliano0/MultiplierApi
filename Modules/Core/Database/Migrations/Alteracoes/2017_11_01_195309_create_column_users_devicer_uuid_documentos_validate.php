<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumnUsersDevicerUuidDocumentosValidate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

		Schema::table('seguranca.tb_usuario', function (Blueprint $table) {
			$table->string('device_uuid')->nullable();
			$table->string('remember_token')->nullable();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		if (Schema::hasColumn('seguranca.tb_usuario', 'device_uuid')) {
			Schema::table('seguranca.tb_usuario', function (Blueprint $table) {
				$table->dropColumn('device_uuid');
				$table->dropColumn('remember_token');
			});
		}
    }
}
