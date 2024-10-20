@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Criar Produto</h1>
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" class="form-control" id="price" name="price" required>
            </div>
            <div class="form-group">
                <label for="dimensions">Dimensions (Height x Width x Length)</label>
                <input type="text" class="form-control" id="height" name="height" placeholder="Height" required>
                <input type="text" class="form-control mt-2" id="width" name="width" placeholder="Width" required>
                <input type="text" class="form-control mt-2" id="length" name="length" placeholder="Length" required>
            </div>
            <div class="form-group">
                <label for="weight">Weight</label>
                <input type="text" class="form-control" id="weight" name="weight" required>
            </div>
            <div class="form-group">
                <label for="image">Product Image</label>
                <input type="file" class="form-control-file" id="image" name="image" required>
            </div>
            <button type="submit" class="btn btn-success mt-3">Create</button>
        </form>
    </div>
@endsection
