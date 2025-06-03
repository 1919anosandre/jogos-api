@extends('layouts.app')

@section('content')
<h1>Editar Gênero</h1>

<form action="{{ route('genres.update', $genre) }}" method="POST">
    @csrf
    @method('PUT')
    <label>Nome do Gênero</label><br>
    <input type="text" name="name" value="{{ old('name', $genre->name) }}">
    @error('name')<div style="color:red">{{ $message }}</div>@enderror
    <br><br>
    <button type="submit">Atualizar</button>
</form>
@endsection
