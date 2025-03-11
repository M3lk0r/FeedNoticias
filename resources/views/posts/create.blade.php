<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Nova Notícia</title>
</head>
<body>
    <h1>Criar Nova Notícia</h1>
    <form action="{{ route('posts.store') }}" method="POST">
        @csrf
        <label for="title">Título:</label>
        <input type="text" name="title" required><br>

        <label for="content">Conteúdo:</label>
        <textarea name="content" rows="5" required></textarea><br>

        <label for="published">Tipo de Publicação:</label>
        <select name="published">
            <option value="immediate">Publicação Imediata</option>
            <option value="scheduled">Agendada</option>
        </select><br>

        <label for="scheduled_at">Data/Hora (para agendamento):</label>
        <input type="datetime-local" name="scheduled_at"><br>

        <button type="submit">Enviar Notícia</button>
    </form>
    <p><a href="{{ route('home') }}">Voltar ao Feed</a></p>
</body>
</html>