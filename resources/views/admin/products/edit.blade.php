@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Editar Produto</h1>
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" class="form-control" id="price" name="price" value="{{ $product->price }}" required>
            </div>
            <div class="form-group">
                <label for="dimensions">Dimensions (Height x Width x Length)</label>
                <input type="text" class="form-control" id="height" name="height" value="{{ $product->height }}"
                       required>
                <input type="text" class="form-control mt-2" id="width" name="width" value="{{ $product->width }}"
                       required>
                <input type="text" class="form-control mt-2" id="length" name="length" value="{{ $product->length }}"
                       required>
            </div>
            <div class="form-group">
                <label for="weight">Weight</label>
                <input type="text" class="form-control" id="weight" name="weight" value="{{ $product->weight }}"
                       required>
            </div>
            <div class="form-group">
                <label for="image">Product Image</label>
                <input type="file" class="form-control-file" id="image" name="image">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" width="100" class="mt-3">
                @endif
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update</button>
        </form>
    </div>
@endsection
