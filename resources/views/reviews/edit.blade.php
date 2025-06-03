@extends('layouts.app')

@section('content')
<h1>Editar Review</h1>

<form action="{{ route('reviews.update', $review) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Usuário</label><br>
    <input type="text" name="user_name" value="{{ old('user_name', $review->user_name) }}">
    @error('user_name')<div style="color:red">{{ $message }}</div>@enderror
    <br>

    <label>Jogo</label><br>
    <select name="game_id">
        <option value="">Selecione um jogo</option>
        @foreach ($games as $game)
            <option value="{{ $game->id }}" {{ old('game_id', $review->game_id) == $game->id ? 'selected' : '' }}>
                {{ $game->title }}
            </option>
        @endforeach
    </select>
    @error('game_id')<div style="color:red">{{ $message }}</div>@enderror
    <br>

    <label>Conteúdo</label><br>
    <textarea name="content">{{ old('content', $review->content) }}</textarea>
    @error('content')<div style="color:red">{{ $message }}</div>@enderror
    <br>

    <label>Nota (1 a 5)</label><br>
    <input type="number" name="rating" min="1" max="5" value="{{ old('rating', $review->rating) }}">
    @error('rating')<div style="color:red">{{ $message }}</div>@enderror
    <br><br>

    <button type="submit">Atualizar</button>
</form>
@endsection
