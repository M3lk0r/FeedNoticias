<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Feed de Notícias</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.0/echo.iife.js"></script>
    <!-- Inclua o script do Pusher ou de seu servidor de broadcasting se necessário -->
</head>
<body>
    <header>
        <h1>Feed de Notícias</h1>
        @if(Auth::check())
            <p>Bem-vindo, {{ Auth::user()->name }} | <a href="{{ route('logout') }}">Sair</a> | <a href="{{ route('posts.create') }}">Nova Notícia</a></p>
            @if(Auth::user()->isAdmin())
                <p><a href="{{ route('admin.dashboard') }}">Painel Administrativo</a></p>
            @endif
        @else
            <a href="{{ route('login.microsoft') }}">Login com Microsoft</a>
        @endif
    </header>

    <section>
        @foreach($posts as $post)
            <article>
                <h2>{{ $post->title }}</h2>
                <p>{{ $post->content }}</p>
                <small>Publicado em: {{ $post->published_at }} por {{ $post->user->name }}</small>
            </article>
        @endforeach
    </section>

    <!-- Script para receber notificações via WebSockets -->
    <script>
        // Inicialize o Laravel Echo (ex: com Pusher). Configuração de exemplo:
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: 'SUA_CHAVE_PUSHER',
            cluster: 'SUA_CLUSTER',
            forceTLS: true
        });

        // Escuta o canal "news-feed"
        Echo.channel('news-feed')
            .listen('PostPublished', (event) => {
                // Solicita permissão para Web Notifications (caso não tenha sido concedida)
                if (Notification.permission !== "granted") {
                    Notification.requestPermission();
                }

                // Exibe a notificação
                if (Notification.permission === "granted") {
                    new Notification("Nova Notícia Publicada", {
                        body: event.title,
                        icon: '/path/to/icon.png'
                    });
                }
                // Opcional: atualizar o feed dinamicamente
            });
    </script>

    <!-- Registra o Service Worker se disponível -->
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js').then(function(registration) {
                console.log('Service Worker registrado com sucesso:', registration);
            }).catch(function(error) {
                console.log('Falha ao registrar o Service Worker:', error);
            });
        }
    </script>
</body>
</html>