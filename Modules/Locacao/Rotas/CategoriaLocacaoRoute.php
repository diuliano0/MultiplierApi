<?php

    namespace Modules\Locacao\Rotas;

	//use Modules\Locacao\Enuns\Rotina;
	use App\Interfaces\ICustomRoute;
    use \Route;

class CategoriaLocacaoRoute implements ICustomRoute
{
    public static function run()
    {
		\Route::group(["prefix"=>"admin/locacao","middleware" => ["auth:api"],"namespace"=>"Api\Admin"],function () {
            Route::get('categorialocacao/lista', [
                'as' => 'locacao.categorialocacao.lista',
                'uses' => 'CategoriaLocacaoController@lista'
            ]);
			\Route::resource("categorialocacao", "CategoriaLocacaoController",
				[
					//"middleware" => [Rotina::middlewareForm("possuiRotina", Rotina::GERENCIAR_PROFISSIONAL_SAUDE)],
					"except" => ["create", "edit"]
				]);
		});
	}
}
