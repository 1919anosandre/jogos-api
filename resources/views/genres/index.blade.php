


33@extends('layouts.app')

@section('content')
<h1>Gêneros</h1>
<a href="{{ route('genres.create') }}">Adicionar Novo Gênero</a>

<ul>
    @foreach ($genres as $genre)
        <li>
            {{ $genre->name }}
            <a href="{{ route('genres.edit', $genre) }}">Editar</a>
            <form action="{{ route('genres.destroy', $genre) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Quer mesmo deletar este gênero?')">Deletar</button>
            </form>
        </li>
    @endforeach
</ul>
@endsection
