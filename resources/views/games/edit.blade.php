<!-- resources/views/games/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Editar Jogo: {{ $game->title }}</h1>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('games.update', $game->id) }}" method="POST" id="game-update-form">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="title" class="form-label">Título *</label>
            <input type="text" name="title" id="title" 
                   class="form-control @error('title') is-invalid @enderror" 
                   value="{{ old('title', $game->title) }}" required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="description" class="form-label">Descrição *</label>
            <textarea name="description" id="description" 
                      class="form-control @error('description') is-invalid @enderror" 
                      rows="5" required>{{ old('description', $game->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="genre_id" class="form-label">Gênero *</label>
            <select name="genre_id" id="genre_id" 
                    class="form-select @error('genre_id') is-invalid @enderror" required>
                <option value="">Selecione um gênero</option>
                @foreach($genres as $genre)
                    <option value="{{ $genre->id }}" 
                        {{ old('genre_id', $game->genre_id) == $genre->id ? 'selected' : '' }}>
                        {{ $genre->name }}
                    </option>
                @endforeach
            </select>
            @error('genre_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-4">
            <label class="form-label">Plataformas</label>
            <div class="row">
                @foreach($platforms as $platform)
                    <div class="col-md-3 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" 
                                   name="platforms[]" 
                                   id="platform_{{ $platform->id }}" 
                                   value="{{ $platform->id }}"
                                   {{ in_array($platform->id, old('platforms', $game->platforms->pluck('id')->toArray())) ? 'checked' : '' }}>
                            <label class="form-check-label" for="platform_{{ $platform->id }}">
                                {{ $platform->name }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
            @error('platforms')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Atualizar Jogo
            </button>
            <a href="{{ route('games.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </form>
</div>
@endsection