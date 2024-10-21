@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Detalhes do Pedido</h1>

        <!-- Informações do Cliente -->
        <ul>
            <li><strong>Nome do Cliente:</strong> {{ $order->customer->name }}</li>
            <li><strong>CPF:</strong> {{ $order->customer->cpf }}</li>
            <li><strong>Endereço:</strong> {{ $order->customer->address }}, {{ $order->customer->number }}</li>
            <li><strong>Complemento:</strong> {{ $order->customer->complement ?? 'N/A' }}</li>
            <li><strong>Bairro:</strong> {{ $order->customer->neighborhood }}</li>
            <li><strong>Cidade:</strong> {{ $order->customer->city }} - {{ $order->customer->state }}</li>
            <li><strong>CEP:</strong> {{ $order->customer->postal_code }}</li>
            <li><strong>Telefone:</strong> {{ $order->customer->cellphone }}</li>
            <li><strong>Email:</strong> {{ $order->customer->email }}</li>
        </ul>

        <!-- Detalhes do Pedido -->
        <h2>Informações do Pedido</h2>
        <ul>
            <li><strong>ID do Pedido:</strong> {{ $order->id }}</li>
            <li><strong>Total do Pedido:</strong> R$ {{ number_format($order->total, 2, ',', '.') }}</li>
            <li><strong>Status:</strong> {{ ucfirst($order->status) }}</li>
            <li><strong>Data do Pedido:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</li>
        </ul>

        <!-- Itens do Pedido -->
        <h3>Itens do Pedido</h3>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Produto</th>
                <th>Preço Unitário</th>
                <th>Quantidade</th>
                <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>R$ {{ number_format($item->product->price, 2, ',', '.') }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>R$ {{ number_format($item->subtotal, 2, ',', '.') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
