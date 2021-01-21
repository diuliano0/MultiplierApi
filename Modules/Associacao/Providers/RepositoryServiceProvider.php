<?php

namespace Modules\Associacao\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Associacao\Repositories\BannerAssociadoRepository;
use Modules\Associacao\Repositories\BannerAssociadoRepositoryEloquent;
use Modules\Associacao\Repositories\CarteirinhaRepository;
use Modules\Associacao\Repositories\CarteirinhaRepositoryEloquent;
use Modules\Associacao\Repositories\DependenteRepository;
use Modules\Associacao\Repositories\DependenteRepositoryEloquent;
use Modules\Associacao\Repositories\NoticiaRepository;
use Modules\Associacao\Repositories\NoticiaRepositoryEloquent;
use Modules\Associacao\Repositories\TrabalhadorRepository;
use Modules\Associacao\Repositories\TrabalhadorRepositoryEloquent;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            TrabalhadorRepository::class,
			TrabalhadorRepositoryEloquent::class
        );
        $this->app->bind(
            DependenteRepository::class,
			DependenteRepositoryEloquent::class
        );
        $this->app->bind(
            CarteirinhaRepository::class,
			CarteirinhaRepositoryEloquent::class
        );
        $this->app->bind(
            NoticiaRepository::class,
			NoticiaRepositoryEloquent::class
        );
        $this->app->bind(
            BannerAssociadoRepository::class,
            BannerAssociadoRepositoryEloquent::class
        );
    }
}
