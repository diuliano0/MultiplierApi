<?php

namespace Modules\Associacao\Rotas;

//use Modules\Associacao\Enuns\Rotina;
use App\Interfaces\ICustomRoute;
use \Route;

class BannerAssociadoRoute implements ICustomRoute
{
    public static function run()
    {

        Route::group(["prefix" => "admin/associacao", "middleware" => ["auth:api"], "namespace" => "Api\Admin"], function () {
            Route::resource("bannerassociado", "BannerAssociadoController",
                [
                    //"middleware" => [Rotina::middlewareForm("possuiRotina", Rotina::GERENCIAR_PROFISSIONAL_SAUDE)],
                    "except" => ["create", "edit"]
                ]);
        });

        Route::group(["prefix" => "front/associacao", "middleware" => ["auth:api"], "namespace" => "Api\Front"], function () {
            Route::get('bannerassociado/bannerAleatorio', [
                'as' => 'associacao.bannerassociado.bannerAleatorio.no_context_md',
                'uses' => 'BannerAssociadoController@bannerAleatorio'
            ]);
        });

    }
}
