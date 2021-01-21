<?php

    namespace Modules\Associacao\Rotas;

	//use Modules\Associacao\Enuns\Rotina;
	use App\Interfaces\ICustomRoute;
    use \Route;

class NoticiaRoute implements ICustomRoute
{
    public static function run()
    {
		Route::group(["prefix"=>"admin/associacao","middleware" => ["auth:api"],"namespace"=>"Api\Admin"],function () {
			Route::resource("noticia", "NoticiaController",
				[
					//"middleware" => [Rotina::middlewareForm("possuiRotina", Rotina::GERENCIAR_PROFISSIONAL_SAUDE)],
					"except" => ["create", "edit"]
				]);
		});

		Route::group(["prefix"=>"front/associacao","middleware" => ["auth:api"],"namespace"=>"Api\Front"],function () {
			Route::get('noticia', [
				'as' => 'associacao.noticia.index.no_context_md',
				'uses' => 'NoticiaController@index'
			]);
			Route::get('noticia/{id}', [
				'as' => 'associacao.noticia.show.no_context_md',
				'uses' => 'NoticiaController@show'
			]);
		});
	}
}
