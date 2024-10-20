@extends('layouts.app')

@section('content')
    <form action="/customers" method="POST">
        @csrf
        @include('app.customers._form')
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
@endsection
