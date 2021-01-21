<?php

    namespace Modules\Associacao\Rotas;

	//use Modules\Associacao\Enuns\Rotina;
	use App\Interfaces\ICustomRoute;
    use \Route;

class TrabalhadorRoute implements ICustomRoute
{
    public static function run()
    {
		Route::group(["prefix"=>"admin/associacao","middleware" => ["auth:api"],"namespace"=>"Api\Admin"],function () {
			Route::get('trabalhador/pesquisar/{query}', [
				'as' => 'saude.trabalhador.pesquisar',
				'uses' => 'TrabalhadorController@pesquisar'
			]);

			Route::post('trabalhador/enviarMsg', [
				'as' => 'saude.trabalhador.enviarMsg',
				'uses' => 'TrabalhadorController@enviarMsg'
			]);

			Route::resource("trabalhador", "TrabalhadorController",
				[
					//"middleware" => [Rotina::middlewareForm("possuiRotina", Rotina::GERENCIAR_PROFISSIONAL_SAUDE)],
					"except" => ["create", "edit"]
				]);
		});

        /*Route::get('front/associacao/trabalhador/teste', [
            'as' => 'associacao.trabalhador.teste.no_context_md',
            'uses' => 'Api\Front\TrabalhadorController@teste'
        ]);*/

		Route::group(["prefix"=>"front/associacao","middleware" => ["auth:api"],"namespace"=>"Api\Front"], function () {

			Route::get('trabalhador/perfil', [
				'as' => 'associacao.trabalhador.perfil.no_context_md',
				'uses' => 'TrabalhadorController@perfil'
			]);

			Route::post('trabalhador/mudar-imagem', [
				'as' => 'associacao.trabalhador.mudarImagem.no_context_md',
				'uses' => 'TrabalhadorController@mudarImagem'
			]);

			Route::post('trabalhador/enviarEmail', [
				'as' => 'associacao.trabalhador.enviarEmail.no_context_md',
				'uses' => 'TrabalhadorController@enviarEmail'
			]);

			Route::post('trabalhador/enviarSabEmail', [
				'as' => 'associacao.trabalhador.enviarSabEmail.no_context_md',
				'uses' => 'TrabalhadorController@enviarSabEmail'
			]);

			Route::put('trabalhador', [
				'as' => 'associacao.trabalhador.atualizar.no_context_md',
				'uses' => 'TrabalhadorController@atualizar'
			]);

		});
	}
}
