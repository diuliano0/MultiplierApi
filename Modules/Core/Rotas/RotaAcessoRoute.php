<?php

    namespace Modules\Core\Rotas;

	//use Modules\Core\Enuns\Rotina;
	use App\Interfaces\ICustomRoute;
    use \Route;

class RotaAcessoRoute implements ICustomRoute
{
    public static function run()
    {
		Route::group(["prefix"=>"admin/core","middleware" => ["auth:api"],"namespace"=>"Api\Admin"],function () {
			Route::post('rotaacesso/lista-acesso',[
				'as' => 'core.rotaacesso.lista-acesso',
				'uses' => 'RotaAcessoController@rotaByModulo'
			]);
			Route::get('rotaacesso/lista-ambiente',[
				'as' => 'core.rotaacesso.lista-ambiente',
				'uses' => 'RotaAcessoController@listaAmbientes'
			]);
			Route::resource('rotaacesso', "RotaAcessoController",
				[
					//"middleware" => [Rotina::middlewareForm("possuiRotina", Rotina::GERENCIAR_PROFISSIONAL_SAUDE)],
					"except" => ["create", "edit"]
				]);
		});
	}
}
