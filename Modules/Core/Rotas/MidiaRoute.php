<?php

    namespace Modules\Core\Rotas;

	use Modules\Saude\Enuns\Rotina;
	use App\Interfaces\ICustomRoute;
    use \Route;

class MidiaRoute implements ICustomRoute
{
    public static function run()
    {
		Route::group(["prefix"=>"admin/core","middleware" => ["auth:api"],"namespace"=>"Api\Admin"],function () {
			Route::resource("midia", "MidiaController",
				[
					//"middleware" => [Rotina::middlewareForm("possuiRotina", Rotina::GERENCIAR_PROFISSIONAL_SAUDE)],
					"except" => ["create", "edit"]
				]);
		});
	}
}
