<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use Carbon\Carbon;
use App\Events\PostPublished;

class PublishScheduledPosts extends Command
{
    // Nome e assinatura do comando
    protected $signature = 'posts:publish-scheduled';

    // Descrição do comando
    protected $description = 'Publica as postagens agendadas que já atingiram a data/hora de publicação';

    public function handle()
    {
        $now = Carbon::now();
        
        // Busca todos posts agendados cuja data seja menor ou igual ao momento atual
        $posts = Post::where('status', 'scheduled')
                     ->where('scheduled_at', '<=', $now)
                     ->get();

        if ($posts->isEmpty()) {
            $this->info('Nenhuma postagem agendada para publicação no momento.');
            return;
        }

        foreach ($posts as $post) {
            // Publica o post (o método publish atualiza status e published_at)
            $post->publish();
            // Dispara o evento de notificação
            event(new PostPublished($post));
            $this->info("Post {$post->id} publicado com sucesso.");
        }
    }
}