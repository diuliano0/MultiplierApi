<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMotivoCancelamentoReservas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('locacao.reservas', function (Blueprint $table) {
            $table->integer('motivo_cancelamento')->nullable();
            $table->text('motivo_cancelamento_texto')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('locacao.reservas', function (Blueprint $table) {
            $table->dropColumn('motivo_cancelamento');
            $table->dropColumn('motivo_cancelamento_texto');
        });
    }
}
