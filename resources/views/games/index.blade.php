@extends('layouts.app')

@section('content')
<h1>Games</h1>
<a href="{{ route('games.create') }}">Adicionar Novo Game</a>

<ul>
    @foreach ($games as $game)
        <li>
            {{ $game->title }} - Gênero: {{ $game->genre->name ?? 'N/A' }}
            <a href="{{ route('games.edit', $game) }}">Editar</a>
            <form action="{{ route('games.destroy', $game) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Quer mesmo deletar?')">Deletar</button>
            </form>
        </li>
    @endforeach
</ul>
@endsection
