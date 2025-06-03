@extends('layouts.app')

@section('content')
<h1>Plataformas</h1>
<a href="{{ route('platforms.create') }}">Adicionar Nova Plataforma</a>

<ul>
    @foreach ($platforms as $platform)
        <li>
            {{ $platform->nome }}
            <a href="{{ route('platforms.edit', $platform) }}">Editar</a>
            <form action="{{ route('platforms.destroy', $platform) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Quer mesmo deletar esta plataforma?')">Deletar</button>
            </form>
        </li>
    @endforeach
</ul>
@endsection
