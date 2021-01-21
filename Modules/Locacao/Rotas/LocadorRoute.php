<?php

    namespace Modules\Locacao\Rotas;

	//use Modules\Locacao\Enuns\Rotina;
	use App\Interfaces\ICustomRoute;
    use \Route;

class LocadorRoute implements ICustomRoute
{
    public static function run()
    {
		Route::group(["prefix"=>"admin/locacao","middleware" => ["auth:api"],"namespace"=>"Api\Admin"],function () {
            Route::get('locador/pesquisar/{query}', [
                'as' => 'locacao.locador.pesquisar',
                'uses' => 'LocadorController@pesquisar'
            ]);
		    Route::resource("locador", "LocadorController",
				[
					//"middleware" => [Rotina::middlewareForm("possuiRotina", Rotina::GERENCIAR_PROFISSIONAL_SAUDE)],
					"except" => ["create", "edit"]
				]);
		});

        Route::group(["prefix"=>"front/locacao","middleware" => ["auth:api"],"namespace"=>"Api\Front"], function () {

            Route::get('locador/perfil', [
                'as' => 'locacao.locador.perfil.no_context_md',
                'uses' => 'LocadorController@perfil'
            ]);

            Route::post('locador/mudar-imagem', [
                'as' => 'locacao.locador.mudarImagem.no_context_md',
                'uses' => 'LocadorController@mudarImagem'
            ]);

            Route::put('locador', [
                'as' => 'locacao.locador.atualizar.no_context_md',
                'uses' => 'LocadorController@atualizar'
            ]);

        });

        Route::post('front/locacao/locador', [
            'as' => 'locacao.locador.atualizar.no_context_md',
            'uses' => 'Api\Front\LocadorController@store'
        ]);
	}
}
