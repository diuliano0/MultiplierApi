<?php

namespace Modules\Core\Events;

use Illuminate\Queue\SerializesModels;

class NotificacaoEvent
{
    use SerializesModels;


    private $userId;
    private $titulo;
    private $messagem;

    public function __construct($userId, $titulo, $messagem)
    {

        $this->userId = $userId;
        $this->titulo = $titulo;
        $this->messagem = $messagem;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
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
