<?php

namespace Modules\Locacao\Rotas;

//use Modules\Locacao\Enuns\Rotina;
use App\Interfaces\ICustomRoute;
use \Route;

class HorarioRoute implements ICustomRoute
{
    public static function run()
    {
        Route::group(["prefix" => "admin/locacao", "middleware" => ["auth:api"], "namespace" => "Api\Admin"], function () {

            Route::get('horario/horariosByMesByLocacao/{idLocacao}/{mes}/{ano}', [
                'as' => 'locacao.locacao.horariosByMesByLocacao',
                'uses' => 'HorarioController@horariosByMesByLocacao'
            ]);

            Route::post('horario/smartStore', [
                'as' => 'locacao.locacao.smartStore',
                'uses' => 'HorarioController@smartStore'
            ]);

            Route::resource("horario", "HorarioController",
                [
                    //"middleware" => [Rotina::middlewareForm("possuiRotina", Rotina::GERENCIAR_PROFISSIONAL_SAUDE)],
                    "except" => ["create", "edit"]
                ]);
        });
    }
}
