<?php

namespace Modules\Associacao\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Associacao\Events\EnviarEmailBeneficioEvent;
use Modules\Core\Enuns\EmailBeneficioEnum;

class EnviarEmailBeneficiosListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param EnviarEmailBeneficioEvent $event
     * @return void
     */
    public function handle(EnviarEmailBeneficioEvent $event)
    {
        $tipoEnum = (new EmailBeneficioEnum($event->getData()['tipo']))->toArray();
        mail_queue([
            //'qimob@qative.com.br' => 'MedBrasil',
            'aplicativo@fundacaoprotocantins.org' => 'Atendimento Pro-tocantins',
            //'diuliano0@gmail.com' => 'MedBrasil',
        ],
        'Solicitação de Atendimento - '.$tipoEnum['data']['descricao'],
        'modules.associacao.email.email-beneficio.agendamento-readendado',
        [
            'data' => $event->getData()
        ]);
    }
}
