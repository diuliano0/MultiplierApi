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
class GrupoRoute implements ICustomRoute
{
    public static function run()
    {
		Route::group(['prefix'=>'admin/core','middleware' => ['auth:api'],'namespace'=>'Api\Admin'],function () {
			/*Route::group(['middleware' => ['acl'], 'is' => 'administrador', 'protect_alias' => 'user'], function (
			});*/
			//ativarDesativar
			Route::get('grupo/desativar-ativar/{id}', [
				'as' => 'grupo.desativarAtivar',
				'uses' => 'GrupoController@ativarDesativar'
			]);
			Route::get('grupo/select-grupos', [
				'as' => 'grupo.selectGrupo',
				'uses' => 'GrupoController@selectGrupo'
			]);
			Route::get('grupo/listDashBoard', [
				'as' => 'grupo.listDashBoard',
				'uses' => 'GrupoController@listDashBoard'
			]);

			Route::resource('grupo', 'GrupoController',
				[
					//'middleware' => [Rotina::middlewareForm('possuiRotina', Rotina::PERFIL_USUARIO)],
					'except' => ['create', 'edit']
				]);
		});
	}
}
