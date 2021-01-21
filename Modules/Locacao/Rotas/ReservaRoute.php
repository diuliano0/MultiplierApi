<?php

    namespace Modules\Locacao\Rotas;

	use App\Interfaces\ICustomRoute;
    use \Route;

class ReservaRoute implements ICustomRoute
{
    public static function run()
    {
		Route::group(["prefix"=>"admin/locacao","middleware" => ["auth:api"],"namespace"=>"Api\Admin"],function () {
            Route::get('reserva/agendar/{horarioId}/{locadorId}', [
                'as' => 'locacao.reservar.agendar',
                'uses' => 'ReservaController@agendar'
            ]);
            Route::get('reserva/cancelar/{horarioId}', [
                'as' => 'locacao.reservar.cancelar',
                'uses' => 'ReservaController@cancelar'
            ]);
            Route::get('reserva', [
                'as' => 'locacao.reservar',
                'uses' => 'ReservaController@index'
            ]);
			/*Route::resource("reserva", "ReservaController",
				[
					//"middleware" => [Rotina::middlewareForm("possuiRotina", Rotina::GERENCIAR_PROFISSIONAL_SAUDE)],
					"except" => ["create", "edit"]
				]);*/
		});
	}
}
