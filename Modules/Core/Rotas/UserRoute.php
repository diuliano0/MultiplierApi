<?php
    namespace Modules\Core\Rotas;
    use Modules\Core\Enuns\Rotina;
	use Modules\Core\Http\Middleware\RotinaControleDeAcesso;
	use App\Interfaces\ICustomRoute;
    use \Route;
/**
 * Created by PhpStorm.
 * User: dsoft
 * Date: 06/02/2017
 * Time: 15:22
 */
class UserRoute implements ICustomRoute
{
    public static function run()
    {
		Route::post('admin/core/user/password/reset/change', [
			'as' => 'admin.user.criar_nova_senha.no_context_md',
			'uses' => 'Api\Front\UserController@criarNovaSenha',
		]);
		Route::post('admin/core/user/password/reset', [
			'as' => 'admin.user.solicitar_nova_senha.no_context_md',
			'uses' => 'Api\Front\UserController@solicitarNovaSenha'
		]);
		Route::group(['prefix'=>'admin/core','middleware' => ['auth:api'],'namespace'=>'Api\Admin'],function () {
			Route::get('user/perfil', [
				'as' => 'user.perfil',
				'uses' => 'UserController@perfil'
			]);
			Route::get('user/sair', [
				'as' => 'user.sair',
				'uses' => 'UserController@logout'
			]);
			//->middleware(Rotina::middlewareForm('possuiRotina', Rotina::PERFIL_USUARIO))
			Route::put('user/userupdate', [
				'as' => 'user.alterar_senha',
				'uses' => 'UserController@updateCurrentUser',
			]);
			Route::get('user/desativar-ativar/{id}', [
				'as' => 'user.desativar-ativar',
				'uses' => 'UserController@ativarDesativar'
			]);//->middleware(Rotina::middlewareForm('possuiRotina', Rotina::PERFIL_USUARIO));
			Route::put('user/password/change', [
				'as' => 'user.alterar_senha',
				'uses' => 'UserController@alterarSenha',
			]);
			Route::get('user/pesquisar/{query}', [
				'as' => 'core.user.pesquisar',
				'uses' => 'UserController@pesquisar'
			]);
			Route::resource('user', 'UserController',
				[
					//'middleware' => [Rotina::middlewareForm('possuiRotina', Rotina::PERFIL_USUARIO)],
					'except' => ['create', 'edit']
				]);
		});
		Route::group(['prefix'=>'front/core','middleware' => ['auth:api'],'namespace'=>'Api\Front'],function () {
            Route::get('user/notificacoes', [
                'as' => 'user.front.notificacoes.no_context_md',
                'uses' => 'UserController@notificacoes'
            ]);
		    Route::put('user/password/change', [
				'as' => 'user.alterar_senha.no_context_md',
				'uses' => 'UserController@alterarSenha',
			]);
		});
	}
}
