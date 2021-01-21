<?php
Route::group(['prefix'=>'v1'], function () {
    \Modules\Locacao\Rotas\CategoriaLocacaoRoute::run();
    \Modules\Locacao\Rotas\FaturaRoute::run();
    \Modules\Locacao\Rotas\LocacaoRoute::run();
    \Modules\Locacao\Rotas\LocadorRoute::run();
    \Modules\Locacao\Rotas\ReservaRoute::run();
    \Modules\Locacao\Rotas\HorarioRoute::run();
});
