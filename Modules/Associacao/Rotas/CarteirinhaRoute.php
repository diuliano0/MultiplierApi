<?php

    namespace Modules\Associacao\Rotas;

	//use Modules\Associacao\Enuns\Rotina;
	use App\Interfaces\ICustomRoute;
    use \Route;

class CarteirinhaRoute implements ICustomRoute
{
    public static function run()
    {
		Route::group(["prefix"=>"admin/associacao","middleware" => ["auth:api"],"namespace"=>"Api\Admin"],function () {
			Route::post('carteirinha/gerar/{id}', [
				'as' => 'associacao.carteirinha.gerar',
				'uses' => 'CarteirinhaController@gerarCarteirinha',
			]);
			Route::resource("carteirinha", "CarteirinhaController",
				[
					//"middleware" => [Rotina::middlewareForm("possuiRotina", Rotina::GERENCIAR_PROFISSIONAL_SAUDE)],
					"except" => ["create", "edit"]
				]);
		});
	}
}
