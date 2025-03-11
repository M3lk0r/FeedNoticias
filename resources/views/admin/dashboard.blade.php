<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel Administrativo</title>
</head>
<body>
    <h1>Painel Administrativo</h1>
    <h2>Usuários Cadastrados</h2>
    <ul>
    @foreach($users as $user)
        <li>{{ $user->name }} ({{ $user->email }}) - {{ $user->role }}</li>
    @endforeach
    </ul>

    <h2>Notícias Publicadas e Agendadas</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Status</th>
                <th>Autor</th>
                <th>Criado em</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->title }}</td>
                <td>{{ $post->status }}</td>
                <td>{{ $post->user->name }}</td>
                <td>{{ $post->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p><a href="{{ route('home') }}">Voltar ao Feed</a></p>
</body>
</html>