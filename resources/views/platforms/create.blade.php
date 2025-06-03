@extends('layouts.app')

@section('content')
<h1>Criar Nova Plataforma</h1>

<form action="{{ route('platforms.store') }}" method="POST">
    @csrf
    <label>Nome da Plataforma</label><br>
    <input type="text" name="name" value="{{ old('name') }}">
    @error('name')<div style="color:red">{{ $message }}</div>@enderror
    <br><br>
    <button type="submit">Salvar</button>
</form>
@endsection
