<?php

namespace Modules\Associacao\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Associacao\Events\EnviarEmailBeneficioEvent;
use Modules\Associacao\Listeners\EnviarEmailBeneficiosListener;

class EventServiceProvider extends ServiceProvider
{

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        EnviarEmailBeneficioEvent::class => [
            EnviarEmailBeneficiosListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

}
