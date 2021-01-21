<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddValueTrabalhadoresDataFiliacao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('associacao.trabalhadores', function (Blueprint $table) {
            $table->timestamp('data_filiacao')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('associacao.trabalhadores', function (Blueprint $table) {
            $table->dropColumn('data_filiacao');
        });
    }
}
