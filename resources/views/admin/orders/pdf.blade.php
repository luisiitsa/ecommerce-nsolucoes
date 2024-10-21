<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pedidos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 20px;
        }

        .table-container {
            width: 100%;
            margin: 20px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th {
            background-color: #f2f2f2;
            padding: 8px;
            font-size: 12px;
        }

        td {
            padding: 8px;
            text-align: left;
        }

        .total {
            text-align: right;
            font-weight: bold;
            padding-right: 20px;
        }

        .footer {
            text-align: center;
            position: fixed;
            bottom: 10px;
            width: 100%;
            font-size: 10px;
            color: #666;
        }

        .customer-details {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<h1>Lista Completa de Pedidos</h1>

<!-- Cabeçalho com dados do cliente -->
<div class="table-container">
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Data de Criação</th>
            <th>Total</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->customer->name }}</td>
                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                <td>R$ {{ number_format($order->total, 2, ',', '.') }}</td>
                <td>{{ ucfirst($order->status) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<!-- Dados detalhados do pedido e itens -->
@foreach ($orders as $order)
    <h2>Detalhes do Pedido #{{ $order->id }}</h2>

    <div class="customer-details">
        <strong>Cliente:</strong> {{ $order->customer->name }}<br>
        <strong>CPF:</strong> {{ $order->customer->cpf }}<br>
        <strong>Endereço:</strong> {{ $order->customer->address }}, {{ $order->customer->number }}<br>
        <strong>Cidade:</strong> {{ $order->customer->city }} - {{ $order->customer->state }}<br>
        <strong>CEP:</strong> {{ $order->customer->postal_code }}<br>
    </div>

    <div class="table-container">
        <table>
            <thead>
            <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Preço Unitário</th>
                <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>R$ {{ number_format($item->product->price, 2, ',', '.') }}</td>
                    <td>R$ {{ number_format($item->subtotal, 2, ',', '.') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="total">
        <strong>Total do Pedido:</strong> R$ {{ number_format($order->total, 2, ',', '.') }}
    </div>
@endforeach

<div class="footer">
    Lista de pedidos gerada em {{ now()->format('d/m/Y H:i') }}
</div>

</body>
</html>
