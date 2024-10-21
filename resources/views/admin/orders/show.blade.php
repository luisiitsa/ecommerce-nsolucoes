@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Detalhes do Pedido</h1>
        <ul>
            <li><strong>Nome do Cliente:</strong> {{ $order->customer->name }}</li>
            <li><strong>CPF:</strong> {{ $order->customer->cpf }}</li>
        </ul>
    </div>
@endsection
