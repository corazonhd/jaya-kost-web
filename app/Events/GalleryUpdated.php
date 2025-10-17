<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class GalleryUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    // Opsional: bisa kirim data gallery terbaru
    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct($message = 'Gallery updated')
    {
        $this->message = $message;
    }

    /**
     * The name of the channel on which the event should broadcast.
     */
    public function broadcastOn()
    {
        // Channel publik untuk semua user yang lihat gallery
        return new Channel('gallery');
    }

    /**
     * Optional: nama event di frontend
     */
    public function broadcastAs()
    {
        return 'GalleryUpdated';
    }
}
