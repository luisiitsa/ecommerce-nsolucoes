@extends('layouts.app')

@section('content')
    <h1>Meu Carrinho</h1>
    @if(session('cart'))
        <table class="table">
            <thead>
            <tr>
                <th>Produto</th>
                <th>Preço</th>
                <th>Quantidade</th>
            </tr>
            </thead>
            <tbody>
            @foreach(session('cart') as $id => $details)
                <tr>
                    <td>{{ $details['name'] }}</td>
                    <td>R$ {{ number_format($details['price'], 2, ',', '.') }}</td>
                    <td>{{ $details['quantity'] }}</td>
                    <td>
                        <!-- Formulário para remover o item do carrinho -->
                        <form action="{{ route('app.cart.remove') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $id }}">
                            <button type="submit" class="btn btn-danger">Remover</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>Seu carrinho está vazio!</p>
    @endif
@endsection
