@extends('layouts.app')

@vite('resources/js/sales.js')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h1>{{ $product->name }}</h1>
                <p>{{ $product->description }}</p>
                <p>{{ $product->height }} x {{ $product->width }} x {{ $product->length }}</p>
                <p>{{ $product->weight }}</p>
                <h3>R$ {{ number_format($product->price, 2, ',', '.') }}</h3>

                {{--                <div class="col-md-6">--}}
                {{--                    <h4>Calcular Frete</h4>--}}
                {{--                    <form id="freteForm">--}}
                {{--                        <div class="form-group">--}}
                {{--                            <label for="cepTo">CEP</label>--}}
                {{--                                <input type="text" class="form-control" id="cepTo" placeholder="Digite o CEP de--}}
                {{--                            destino" required>--}}
                {{--                        </div>--}}
                {{--                        <div class="form-group">--}}
                {{--                            <input type="hidden" class="form-control" id="weight" value="{{ $product->weight }}"--}}
                {{--                                   required>--}}
                {{--                        </div>--}}
                {{--                        <div class="form-group">--}}
                {{--                            <input type="hidden" class="form-control" id="length" value="{{ $product->length }}" required>--}}
                {{--                        </div>--}}
                {{--                        <div class="form-group">--}}
                {{--                            <input type="hidden" class="form-control" id="height" value="{{ $product->height }}" required>--}}
                {{--                        </div>--}}
                {{--                        <div class="form-group">--}}
                {{--                            <input type="hidden" class="form-control" id="width" value="{{ $product->width }}" required>--}}
                {{--                        </div>--}}
                {{--                        <div class="form-group">--}}
                {{--                            <label for="type">Escolha o tipo de Frete</label>--}}
                {{--                            <select class="form-control" id="type" required>--}}
                {{--                                <option value="41106">PAC</option>--}}
                {{--                                <option value="40010">SEDEX</option>--}}
                {{--                            </select>--}}
                {{--                        </div>--}}
                {{--                        <button type="submit" class="btn btn-primary">Calcular Frete</button>--}}
                {{--                    </form>--}}

                {{--                    <div id="resultadoFrete" class="mt-4">--}}
                {{--                        <!-- O resultado do frete será exibido aqui -->--}}
                {{--                    </div>--}}
                {{--                </div>--}}

                <!-- Formulário para adicionar ao carrinho -->
                <form action="{{ route('app.cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="product_name" value="{{ $product->name }}">
                    <input type="hidden" name="product_price" value="{{ $product->price }}">
                    <input type="hidden" name="product_weight" value="{{ $product->weight }}">
                    <input type="hidden" name="product_length" value="{{ $product->length }}">
                    <input type="hidden" name="product_height" value="{{ $product->height }}">
                    <input type="hidden" name="product_width" value="{{ $product->width }}">
                    <button type="submit" class="btn btn-primary">Adicionar ao carrinho</button>
                </form>

                <!-- Botão para comprar agora (redireciona para página de checkout) -->
                <form action="{{ route('app.cart.sale') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="product_name" value="{{ $product->name }}">
                    <input type="hidden" name="product_price" value="{{ $product->price }}">
                    <input type="hidden" name="product_weight" value="{{ $product->weight }}">
                    <input type="hidden" name="product_length" value="{{ $product->length }}">
                    <input type="hidden" name="product_height" value="{{ $product->height }}">
                    <input type="hidden" name="product_width" value="{{ $product->width }}">
                    <button class="btn btn-primary">Comprar agora</button>
                </form>
            </div>
        </div>
    </div>
@endsection
