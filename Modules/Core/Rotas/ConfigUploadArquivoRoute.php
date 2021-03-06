<?php

    namespace Modules\Core\Rotas;

	use Modules\Core\Enuns\Rotina;
	use App\Interfaces\ICustomRoute;
    use \Route;

class ConfigUploadArquivoRoute implements ICustomRoute
{
    public static function run()
    {
		Route::group(["prefix"=>"admin/core","middleware" => ["auth:api"],"namespace"=>"Api\Admin"],function () {
			Route::resource("config-upload-arquivo", "ConfigUploadArquivoController",
				[
					//"middleware" => [Rotina::middlewareForm("possuiRotina", Rotina::GERENCIAR_PROFISSIONAL_SAUDE)],
					"except" => ["create", "edit"]
				]);
		});
	}
}
