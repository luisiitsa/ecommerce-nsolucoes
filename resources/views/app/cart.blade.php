@extends('layouts.app')

@vite('resources/js/cart.js')

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

        @auth('customer')
        <form id="freteCartForm">
            <div id="cart-data" data-cart="{{ json_encode(session('cart')) }}"></div>
            <div class="form-group">
                <label for="cepTo">CEP de Destino</label>
                <input type="text" class="form-control" id="cepTo" name="cepDestino"
                       value="{{ old('cepDestino', session('freight.cepTo')) }}"
                       placeholder="Digite o CEP de destino" required>
            </div>
            <div class="form-group">
                <label for="type">Escolha o tipo de Frete</label>
                <select class="form-control" id="type" name="tipoFrete" required>
                    <option value="41106" {{ old('tipoFrete', session('freight.type')) == '41106' ? 'selected' : ''
                    }}>PAC
                    </option>
                    <option value="40010" {{ old('tipoFrete', session('freight.type')) == '40010' ? 'selected' : ''
                    }}>SEDEX
                    </option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Calcular Frete</button>
        </form>

        @if (session('freight'))
            <div id="resultadoFrete" class="alert alert-info">
                <p><strong>Valor do Frete:</strong> R$ {{ session('freight.value') }}</p>
                <p><strong>Prazo de Entrega:</strong> {{ session('freight.time') }} dias</p>
            </div>
        @else
            <div id="resultadoFrete" class="mt-4">
                <!-- O resultado do frete será exibido aqui -->
            </div>
        @endif
        @endauth

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
                    <p>Por favor, revise suas informações antes de finalizar a compra.</p>

                    <!-- Select para escolher a forma de pagamento -->
                    <div class="mb-3">
                        <label for="paymentMethod" class="form-label">Forma de Pagamento</label>
                        <select class="form-select" id="paymentMethod">
                            <option value="BOLETO">Boleto</option>
                            <option value="CREDIT_CARD">Cartão de Crédito</option>
                        </select>
                    </div>

                    <!-- Campos de Cartão de Crédito (inicialmente escondidos) -->
                    <div id="creditCardFields" style="display: none;">
                        <div class="mb-3">
                            <label for="holderName" class="form-label">Nome no Cartão</label>
                            <input type="text" class="form-control" id="holderName">
                        </div>
                        <div class="mb-3">
                            <label for="cardNumber" class="form-label">Número do Cartão</label>
                            <input type="text" class="form-control" id="cardNumber">
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="expiryMonth" class="form-label">Mês de Expiração</label>
                                <input type="text" class="form-control" id="expiryMonth">
                            </div>
                            <div class="col-md-4">
                                <label for="expiryYear" class="form-label">Ano de Expiração</label>
                                <input type="text" class="form-control" id="expiryYear">
                            </div>
                            <div class="col-md-4">
                                <label for="ccv" class="form-label">CCV</label>
                                <input type="text" class="form-control" id="ccv">
                            </div>
                        </div>
                    </div>

                    <!-- Botão para confirmar a compra -->
                    <button type="button" class="btn btn-success" id="confirmPurchase" data-bs-dismiss="modal">Confirmar
                        Compra
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
