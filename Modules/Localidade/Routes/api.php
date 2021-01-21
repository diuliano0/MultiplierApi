<?php

Route::group(['prefix'=>'v1'], function () {
    \Modules\Localidade\Rotas\LocalidadeRoute::run();
});
