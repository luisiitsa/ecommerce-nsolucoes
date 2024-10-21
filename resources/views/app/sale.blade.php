@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h1>{{ $product->name }}</h1>
                <p>{{ $product->description }}</p>
                <h3>R$ {{ number_format($product->price, 2, ',', '.') }}</h3>

                <!-- Formulário para adicionar ao carrinho -->
                <form action="{{ route('app.cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="product_name" value="{{ $product->name }}">
                    <input type="hidden" name="product_price" value="{{ $product->price }}">
                    <button type="submit" class="btn btn-primary">Adicionar ao carrinho</button>
                </form>

                <!-- Botão para comprar agora (redireciona para página de checkout) -->
                <button class="btn btn-primary">Comprar agora</button>
            </div>
        </div>
    </div>
@endsection
