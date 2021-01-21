<?php

    namespace Modules\Locacao\Rotas;

	//use Modules\Locacao\Enuns\Rotina;
	use App\Interfaces\ICustomRoute;
    use \Route;

class LocacaoRoute implements ICustomRoute
{
    public static function run()
    {
		Route::group(["prefix"=>"admin/locacao","middleware" => ["auth:api"],"namespace"=>"Api\Admin"],function () {
            Route::post('locacao/addImage/{id}', [
                'as' => 'locacao.locacao.addImage',
                'uses' => 'LocacaoController@addImage'
            ]);
            Route::get('locacao/removeImage/{id}', [
                'as' => 'locacao.locacao.removeImage',
                'uses' => 'LocacaoController@removeImage'
            ]);
            Route::get('locacao/listaComodidade', [
                'as' => 'locacao.locacao.listaComodidade',
                'uses' => 'LocacaoController@listaComodidade'
            ]);
            Route::get('locacao/listaLocacoes', [
                'as' => 'locacao.locacao.listaLocacoes',
                'uses' => 'LocacaoController@listaLocacoes'
            ]);
		    Route::resource("locacao", "LocacaoController",
				[
					//"middleware" => [Rotina::middlewareForm("possuiRotina", Rotina::GERENCIAR_PROFISSIONAL_SAUDE)],
					"except" => ["create", "edit"]
				]);
		});
	}
}
