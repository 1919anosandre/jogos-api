@extends('layouts.app')

@section('content')
<h1>Editar Plataforma</h1>

<form action="{{ route('platforms.update', $platform) }}" method="POST">
    @csrf
    @method('PUT')
    <label>Nome da Plataforma</label><br>
    <input type="text" name="name" value="{{ old('name', $platform->name) }}">
    @error('name')<div style="color:red">{{ $message }}</div>@enderror
    <br><br>
    <button type="submit">Atualizar</button>
</form>
@endsection
