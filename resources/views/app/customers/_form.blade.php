<div class="mb-3">
    <label for="name" class="form-label">Nome</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $customer->name ?? '') }}">
</div>

<div class="mb-3">
    <label for="postal_code" class="form-label">CEP</label>
    <input type="text" name="postal_code" class="form-control"
           value="{{ old('postal_code', $customer->postal_code ?? '') }}">
</div>

<div class="mb-3">
    <label for="address" class="form-label">Logradouro</label>
    <input type="text" name="address" class="form-control" value="{{ old('address', $customer->address ?? '') }}">
</div>

<div class="mb-3">
    <label for="number" class="form-label">Número</label>
    <input type="text" name="number" class="form-control" value="{{ old('number', $customer->number ?? '') }}">
</div>

<div class="mb-3">
    <label for="complement" class="form-label">Complemento</label>
    <input type="text" name="complement" class="form-control"
           value="{{ old('complement', $customer->complement ?? '') }}">
</div>

<div class="mb-3">
    <label for="neighborhood" class="form-label">Bairro</label>
    <input type="text" name="neighborhood" class="form-control"
           value="{{ old('neighborhood', $customer->neighborhood ?? '') }}">
</div>

<div class="mb-3">
    <label for="city" class="form-label">Cidade</label>
    <input type="text" name="city" class="form-control" value="{{ old('city', $customer->city ?? '') }}">
</div>

<div class="mb-3">
    <label for="state" class="form-label">Estado</label>
    <input type="text" name="state" class="form-control" value="{{ old('state', $customer->state ?? '') }}">
</div>

<div class="mb-3">
    <label for="cellphone" class="form-label">Celular</label>
    <input type="text" name="cellphone" class="form-control" value="{{ old('cellphone', $customer->cellphone ?? '') }}">
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $customer->email ?? '') }}">
</div>

<div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" name="password" class="form-control">
</div>
