@extends('layouts.app')

@section('content')
<h1>Criar Novo Gênero</h1>

<form action="{{ route('genres.store') }}" method="POST">
    @csrf
    <label>Nome do Gênero</label><br>
    <input type="text" name="name" value="{{ old('name') }}">
    @error('name')<div style="color:red">{{ $message }}</div>@enderror
    <br><br>
    <button type="submit">Salvar</button>
</form>
@endsection
