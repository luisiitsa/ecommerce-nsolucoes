@extends('layouts.app')

@section('title', 'Home - Minha Loja')

@section('content')
    <h1 class="text-center">Produtos</h1>

    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                         alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">R$ {{ number_format($product->price, 2, ',', '.') }}</p>
                        <a href="{{ route('app.sales.product', $product->id) }}" class="btn btn-primary">Ver mais</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
