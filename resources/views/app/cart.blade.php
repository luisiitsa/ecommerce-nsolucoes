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

        @guest('customer')
            <!-- Botão que abre o modal de login se o usuário não estiver logado -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#loginModal">
                Finalizar Compra
            </button>
        @else
            <!-- Botão que abre o modal de finalização de compra se o usuário estiver logado -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#checkoutModal">
                Finalizar Compra
            </button>
        @endguest
    @else
        <p>Seu carrinho está vazio!</p>
    @endif

    <!-- Modal de Finalização de Compra -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checkoutModalLabel">Finalizar Compra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Aqui você pode incluir o formulário de finalização da compra -->
                    <p>Por favor, revise suas informações antes de finalizar a compra.</p>
                    <!-- Exemplo de um botão para continuar para a finalização -->
                    <button type="button" class="btn btn-success">Confirmar Compra</button>
                </div>
            </div>
        </div>
    </div>
@endsection
