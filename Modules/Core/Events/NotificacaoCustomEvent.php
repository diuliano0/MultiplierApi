<?php

namespace Modules\Core\Events;

use Illuminate\Queue\SerializesModels;

class NotificacaoCustomEvent
{
    use SerializesModels;


    private $devices;
    private $titulo;
    private $messagem;

    public function __construct($devices, $titulo, $messagem)
    {

        $this->devices = $devices;
        $this->titulo = $titulo;
        $this->messagem = $messagem;
    }

    /**
     * @return mixed
     */
    public function getDevices()
    {
        return $this->devices;
    }

    /**
     * @return mixed
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * @return mixed
     */
    public function getMessagem()
    {
        return $this->messagem;
    }



    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
