<?php

    namespace Modules\Core\Rotas;

	//use Modules\Core\Enuns\Rotina;
	use App\Interfaces\ICustomRoute;
    use \Route;

class FilialRoute implements ICustomRoute
{
    public static function run()
    {
		Route::group(["prefix"=>"admin/core","middleware" => ["auth:api"],"namespace"=>"Api\Admin"],function () {
            Route::get('filial/pesquisar/{query}', [
                'as' => 'saude.filial.pesquisar',
                'uses' => 'FilialController@pesquisar'
            ]);
			Route::resource("filial", "FilialController",
				[
					//"middleware" => [Rotina::middlewareForm("possuiRotina", Rotina::GERENCIAR_PROFISSIONAL_SAUDE)],
					"except" => ["create", "edit"]
				]);
		});
	}
}
