<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Meu Projeto')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
        <a class="navbar-brand" href="{{ url('/') }}">Games</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('games.index') }}">Jogos</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('platforms.index') }}">Plataformas</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('genres.index') }}">Gêneros</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>
</body>
</html>
