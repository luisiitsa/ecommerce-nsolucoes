@extends('layouts.app')

@vite('resources/js/customer.js')

@section('content')
    <form action="/customers/{{ $customer->id }}" method="POST" id="customerForm">
        @csrf
        @method('PUT')
        @include('app.customers._form')
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
