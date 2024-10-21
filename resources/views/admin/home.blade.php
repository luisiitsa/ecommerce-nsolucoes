@extends('layouts.admin')

@section('title', 'Admin')

@section('content')
    <div class="container">
        <h1>Listagem de Pedidos</h1>

        <form method="GET" action="{{ route('admin.home') }}">
            <div class="form-group">
                <input type="text" name="search" class="form-control" placeholder="Buscar por nome ou CPF"
                       value="{{ request()->input('search') }}">
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        <table class="table table-bordered mt-4">
            <thead>
            <tr>
                <th>#</th>
                <th>Nome do Cliente</th>
                <th>CPF</th>
                <th>Total</th>
                <th>Forma de Pagamento</th>
                <th>Data de Hora da compra</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer->name }}</td>
                    <td>{{ $order->customer->cpf }}</td>
                    <td>{{ $order->total }}</td>
                    <td>{{ $order->type_payment }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-info">Ver Detalhes</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $orders->links() }}

        <a href="{{ route('admin.orders.export', ['format' => 'excel']) }}" class="btn btn-success">Exportar para
            Excel</a>
        <a href="{{ route('admin.orders.export', ['format' => 'pdf']) }}" class="btn btn-danger">Exportar para PDF</a>
    </div>
@endsection
