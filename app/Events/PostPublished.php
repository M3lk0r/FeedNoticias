<?php

namespace App\Events;

use App\Models\Post;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;  // para broadcast em tempo real
use Illuminate\Queue\SerializesModels;

class PostPublished implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    // Canal público – você pode usar canais privados, conforme a necessidade
    public function broadcastOn()
    {
        return new Channel('news-feed');
    }

    public function broadcastWith()
    {
        return [
            'id'          => $this->post->id,
            'title'       => $this->post->title,
            'content'     => $this->post->content,
            'published_at'=> $this->post->published_at,
            'author'      => $this->post->user->name,
        ];
    }
}