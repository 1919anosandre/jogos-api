@extends('layouts.app')

@section('content')
<h1>Reviews</h1>
<a href="{{ route('reviews.create') }}">Adicionar Nova Review</a>

<ul>
    @foreach ($reviews as $review)
        <li>
            <strong>{{ $review->user_name }}</strong> para <em>{{ $review->game->title ?? 'Jogo removido' }}</em>: 
            {{ $review->content }} - Nota: {{ $review->rating }}
            <a href="{{ route('reviews.edit', $review) }}">Editar</a>
            <form action="{{ route('reviews.destroy', $review) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Quer mesmo deletar esta review?')">Deletar</button>
            </form>
        </li>
    @endforeach
</ul>
@endsection
