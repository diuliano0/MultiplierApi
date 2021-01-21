<?php
/**
 * Created by PhpStorm.
 * User: dsoft
 * Date: 30/12/2016
 * Time: 10:44
 */

namespace App\Providers;



use App\Repositories\BuscaAlertaRepository;
use App\Repositories\BuscaAlertaRepositoryEloquent;
use App\Repositories\ClientRepository;
use App\Repositories\ClientRepositoryEloquent;
use App\Repositories\ConfiguracaoRepository;
use App\Repositories\ConfiguracaoRepositoryEloquent;
use App\Repositories\ImagemRepository;
use App\Repositories\ImagemRepositoryEloquent;
use App\Repositories\MensagemFinanceiroRepository;
use App\Repositories\MensagemFinanceiroRepositoryEloquent;
use App\Repositories\PaginaRepository;
use App\Repositories\PaginaRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

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
            ConfiguracaoRepository::class,
            ConfiguracaoRepositoryEloquent::class
        );
        $this->app->bind(
            PaginaRepository::class,
            PaginaRepositoryEloquent::class
        );
        $this->app->bind(
            ImagemRepository::class,
            ImagemRepositoryEloquent::class
        );

        $this->app->bind(
            BuscaAlertaRepository::class,
            BuscaAlertaRepositoryEloquent::class
        );
        $this->app->bind(
            MensagemFinanceiroRepository::class,
            MensagemFinanceiroRepositoryEloquent::class
        );

        $this->app->bind(
            ClientRepository::class,
            ClientRepositoryEloquent::class
        );

    }
}
