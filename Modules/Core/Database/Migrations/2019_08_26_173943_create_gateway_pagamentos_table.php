<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGatewayPagamentosTable extends Migration
{

    public function up()
    {
        Schema::create('core.gateway_pagamentos', function (Blueprint $table) {
            $table->increments('id');
            //todo caso seja necessario separar por filial implementar filial ID
            $table->integer('tipo_gateway');
            $table->double('taxa_credito')->nullable();
            $table->double('taxa_debito')->nullable();
            $table->double('iof')->nullable();
            $table->string('client_code');
            $table->string('token');
            $table->boolean('ativo')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('core.gateway_pagamentos');
    }

}
