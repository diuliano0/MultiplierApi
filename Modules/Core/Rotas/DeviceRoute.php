<?php

    namespace Modules\Core\Rotas;

	//use Modules\Core\Enuns\Rotina;
	use App\Interfaces\ICustomRoute;
    use \Route;

class DeviceRoute implements ICustomRoute
{
    public static function run()
    {
        Route::get('front/core/device/desregistrar/{uuid}', [
            'as' => 'device.filial-atual.no_context_md',
            'uses' => 'Api\Front\DeviceController@desregistrar'
        ]);
		Route::group(["prefix"=>"front/core","middleware" => ["auth:api"],"namespace"=>"Api\Front"],function ($request) {
            Route::post('device/registrar', [
                'as' => 'device.filial-atual.no_context_md',
                'uses' => 'DeviceController@registrar'
            ]);
			/*Route::resource("device", "DeviceController",
				[
					//"middleware" => [Rotina::middlewareForm("possuiRotina", Rotina::GERENCIAR_PROFISSIONAL_SAUDE)],
					"except" => ["create", "edit"]
				]);*/
		});
	}
}
