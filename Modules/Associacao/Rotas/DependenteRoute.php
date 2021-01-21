<?php

    namespace Modules\Associacao\Rotas;

	//use Modules\Associacao\Enuns\Rotina;
	use App\Interfaces\ICustomRoute;
    use \Route;

class DependenteRoute implements ICustomRoute
{
    public static function run()
    {
		Route::group(["prefix"=>"admin/associacao","middleware" => ["auth:api"],"namespace"=>"Api\Admin"],function () {
			Route::resource("dependente", "DependenteController",
				[
					//"middleware" => [Rotina::middlewareForm("possuiRotina", Rotina::GERENCIAR_PROFISSIONAL_SAUDE)],
					"except" => ["create", "edit"]
				]);
		});
	}
}
