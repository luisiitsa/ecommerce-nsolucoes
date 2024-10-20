@extends('layouts.app')

@section('content')
    <form method="POST" action="">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nome Completo</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="postal_code" class="form-label">CEP</label>
            <input type="text" class="form-control" id="postal_code" name="postal_code" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Endereço</label>
            <input type="text" class="form-control" id="address" name="address" required>
        </div>
        <div class="mb-3">
            <label for="number" class="form-label">Número</label>
            <input type="text" class="form-control" id="number" name="number" required>
        </div>
        <div class="mb-3">
            <label for="complement" class="form-label">Complemento</label>
            <input type="text" class="form-control" id="complement" name="complement">
        </div>
        <div class="mb-3">
            <label for="neighborhood" class="form-label">Bairro</label>
            <input type="text" class="form-control" id="neighborhood" name="neighborhood" required>
        </div>
        <div class="mb-3">
            <label for="city" class="form-label">Cidade</label>
            <input type="text" class="form-control" id="city" name="city" required>
        </div>
        <div class="mb-3">
            <label for="state" class="form-label">Estado</label>
            <input type="text" class="form-control" id="state" name="state" maxlength="2" required>
        </div>
        <div class="mb-3">
            <label for="cellphone" class="form-label">Celular</label>
            <input type="text" class="form-control" id="cellphone" name="cellphone" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar Senha</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                   required>
        </div>
        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>
@endsection
