<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('email_alternativo');
            $table->string('sexo')->nullable();
            $table->string('pagina_user')->nullable()->unique();
            $table->string('cpf_cnpj')->nullable();
            $table->string('imagem')->nullable();
            $table->string('cep')->nullable();
            $table->date('data_nascimento')->nullable();
            $table->enum('status',['ativo','boqueado','inativo']);
            $table->boolean('disponivel')->nullable()->default(false);
            $table->boolean('documentos_validate')->nullable()->default(false);
            $table->boolean('chk_newsletter')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
