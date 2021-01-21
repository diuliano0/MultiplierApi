<?php
    namespace Modules\Core\Rotas;
    use Modules\Core\Enuns\Rotina;
	use App\Interfaces\ICustomRoute;
    use \Route;
/**
 * Created by PhpStorm.
 * User: dsoft
 * Date: 06/02/2017
 * Time: 15:22
 */
class CoreRoute implements ICustomRoute
{
    public static function run()
    {
		Route::group(['prefix'=>'admin','middleware' => ['auth:api'],'namespace'=>'Api\Admin'],function () {
			Route::get('core/filial-atual', [
				'as' => 'core.filial-atual',
				'uses' => 'CoreController@filial'
			]);
			Route::get('core/lista-modulos', [
				'as' => 'core.filial.lista_modulos',
				'uses' => 'CoreController@listaModulos'
			]);

			Route::put('core/filial/atualizar', [
				'as' => 'core.filial.atualizar',
				'uses' => 'CoreController@atualizarFilial'
			]);//->middleware(Rotina::middlewareForm('possuiRotina', Rotina::PERFIL_USUARIO));

		});
	}
}
