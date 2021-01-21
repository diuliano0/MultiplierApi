<?php

namespace Modules\Locacao\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Locacao\Repositories\CategoriaLocacaoRepository;
use Modules\Locacao\Repositories\CategoriaLocacaoRepositoryEloquent;
use Modules\Locacao\Repositories\ComodidadeRepository;
use Modules\Locacao\Repositories\ComodidadeRepositoryEloquent;
use Modules\Locacao\Repositories\FaturaRepository;
use Modules\Locacao\Repositories\FaturaRepositoryEloquent;
use Modules\Locacao\Repositories\HorarioRepository;
use Modules\Locacao\Repositories\HorarioRepositoryEloquent;
use Modules\Locacao\Repositories\LocacaoRepository;
use Modules\Locacao\Repositories\LocacaoRepositoryEloquent;
use Modules\Locacao\Repositories\LocadorRepository;
use Modules\Locacao\Repositories\LocadorRepositoryEloquent;
use Modules\Locacao\Repositories\ReservaRepository;
use Modules\Locacao\Repositories\ReservaRepositoryEloquent;

class RepositoryServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
            CategoriaLocacaoRepository::class,
            CategoriaLocacaoRepositoryEloquent::class
        );
        $this->app->bind(
            LocacaoRepository::class,
            LocacaoRepositoryEloquent::class
        );
        $this->app->bind(
            FaturaRepository::class,
            FaturaRepositoryEloquent::class
        );
        $this->app->bind(
            LocadorRepository::class,
            LocadorRepositoryEloquent::class
        );
        $this->app->bind(
            ReservaRepository::class,
            ReservaRepositoryEloquent::class
        );
        $this->app->bind(
            HorarioRepository::class,
            HorarioRepositoryEloquent::class
        );
        $this->app->bind(
            ComodidadeRepository::class,
            ComodidadeRepositoryEloquent::class
        );
    }

}
