@extends('layouts.app')

@vite('resources/js/customer.js')

@section('content')
    <form action="/customers" method="POST" id="customerForm">
        @csrf
        @include('app.customers._form')
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
@endsection
