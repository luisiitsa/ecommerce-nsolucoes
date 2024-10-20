@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Listagem de Produtos</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-3">Novo produto</a>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Valor</th>
                <th>Dimensions</th>
                <th>Weight</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->height }} x {{ $product->width }} x {{ $product->length }}</td>
                    <td>{{ $product->weight }}</td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                              style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
