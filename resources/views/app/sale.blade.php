@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h1>{{ $product->name }}</h1>
                <p>{{ $product->description }}</p>
                <h3>R$ {{ number_format($product->price, 2, ',', '.') }}</h3>
                <button class="btn btn-primary">Adicionar ao carrinho</button>
                <button class="btn btn-primary">Comprar agora</button>
            </div>
        </div>
    </div>
@endsection
