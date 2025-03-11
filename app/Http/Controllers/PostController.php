<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Events\PostPublished;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // Exibe o feed de notícias para qualquer visitante
    public function index()
    {
        // Exibe apenas posts já publicados, ordenados do mais recente
        $posts = Post::where('status', 'published')
                     ->orderBy('published_at', 'desc')
                     ->get();
        return view('home', compact('posts'));
    }

    // Formulário para criar nova postagem (somente para usuários autenticados)
    public function create()
    {
        return view('posts.create');
    }

    // Salva a postagem
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|max:255',
            'content'     => 'required',
            'published'   => 'required|in:immediate,scheduled',
            'scheduled_at'=> 'nullable|date_if:published,scheduled'
        ]);

        $post = new Post();
        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->content = $request->content;

        if ($request->published === 'immediate') {
            $post->publish();
            // Dispara notificação imediato
            event(new PostPublished($post));
        } else {
            // Se agendado, armazena a data/hora do agendamento
            $post->scheduled_at = Carbon::parse($request->scheduled_at);
            $post->status = 'scheduled';
            $post->save();
            // Em um job (ex: via scheduler do Laravel) verifique quando chegar o horário agendado,
            // publique o post e dispare a notificação (vide comando abaixo).
        }

        return redirect('/')->with('success', 'Notícia criada com sucesso!');
    }

    // Método para ser executado posteriormente (via comando ou job) e publicar posts agendados
    public function publishScheduledPosts()
    {
        $now = Carbon::now();
        $posts = Post::where('status', 'scheduled')
                     ->where('scheduled_at', '<=', $now)
                     ->get();
        foreach ($posts as $post) {
            $post->publish();
            event(new PostPublished($post));
        }
    }
}