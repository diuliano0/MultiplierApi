<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigUploadArquivoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core.config_upload_arquivos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quantidade_maxima_arquivo');
            $table->integer('tamanho_maximo_arquivo');
            $table->integer('quantidade_maxima_img');
            $table->integer('tamanho_maximo_img');
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
        Schema::dropIfExists('core.config_upload_arquivos');
    }
}
