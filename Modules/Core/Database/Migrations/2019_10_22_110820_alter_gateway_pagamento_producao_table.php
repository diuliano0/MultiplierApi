<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterGatewayPagamentoProducaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('core.gateway_pagamentos', function (Blueprint $table) {
            $table->boolean('producao')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('core.gateway_pagamentos', function (Blueprint $table) {
            $table->dropColumn('producao');
        });
    }
}
