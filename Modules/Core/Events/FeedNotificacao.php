<?php

namespace Modules\Core\Events;

use Illuminate\Queue\SerializesModels;

class FeedNotificacao
{

    use SerializesModels;

    public $data;
    public $userId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data, $userId)
    {
        $this->data = $data;
        $this->userId = $userId;
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
