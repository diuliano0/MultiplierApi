<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['prefix'=>'v1'], function () {
    \Modules\Associacao\Rotas\CarteirinhaRoute::run();
    \Modules\Associacao\Rotas\DependenteRoute::run();
    \Modules\Associacao\Rotas\NoticiaRoute::run();
    \Modules\Associacao\Rotas\TrabalhadorRoute::run();
    \Modules\Associacao\Rotas\BannerAssociadoRoute::run();
});
