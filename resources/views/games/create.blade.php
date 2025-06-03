@extends('layouts.app')

@section('content')
<h1>Criar Game</h1>

<form action="{{ route('games.store') }}" method="POST">
    @csrf
    <label>Título</label>
    <input type="text" name="title" value="{{ old('title') }}">
    @error('title')<div>{{ $message }}</div>@enderror

    <label>Descrição</label>
    <textarea name="description">{{ old('description') }}</textarea>
    @error('description')<div>{{ $message }}</div>@enderror

    <label>Gênero</label>
    <select name="genre_id">
        <option value="">Selecione</option>
        @foreach ($genres as $genre)
            <option value="{{ $genre->id }}" {{ old('genre_id') == $genre->id ? 'selected' : '' }}>
                {{ $genre->name }}
            </option>
        @endforeach
    </select>
    @error('genre_id')<div>{{ $message }}</div>@enderror

    <label>Plataformas</label>
    @foreach ($platforms as $platform)
        <div>
            <input type="checkbox" name="platforms[]" value="{{ $platform->id }}" {{ in_array($platform->id, old('platforms', [])) ? 'checked' : '' }}>
            {{ $platform->name }}
        </div>
    @endforeach

    <button type="submit">Salvar</button>
</form>
@endsection
