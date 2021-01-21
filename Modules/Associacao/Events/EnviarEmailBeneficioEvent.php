<?php

namespace Modules\Associacao\Events;

use Illuminate\Queue\SerializesModels;

class EnviarEmailBeneficioEvent
{
    use SerializesModels;
    /**
     * @var array
     */
    private $data;

    /**
     * Create a new event instance.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        //
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
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
