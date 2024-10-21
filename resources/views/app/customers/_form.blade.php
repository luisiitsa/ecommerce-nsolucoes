<div class="mb-3">
    <label for="name" class="form-label">Nome</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $customer->name ?? '') }}" id="name">
    <div class="invalid-feedback" id="nameError">O nome deve ter no mínimo 3 caracteres.</div>
</div>

<div class="mb-3">
    <label for="cpf" class="form-label">CPF</label>
    <input type="text" name="cpf" class="form-control" value="{{ old('cpf', $customer->cpf ?? '') }}" id="cpf">
    <div class="invalid-feedback" id="cpfError">CPF é obrigatório.</div>
</div>

<div class="mb-3">
    <label for="postal_code" class="form-label">CEP</label>
    <input type="text" id="postal_code" name="postal_code" class="form-control"
           value="{{ old('postal_code', $customer->postal_code ?? '') }}">
    <div class="invalid-feedback" id="postalCodeError">CEP é obrigatório.</div>
</div>

<div class="mb-3">
    <label for="address" class="form-label">Logradouro</label>
    <input type="text" id="address" name="address" class="form-control"
           value="{{ old('address', $customer->address ?? '') }}">
    <div class="invalid-feedback" id="addressError">Logradouro é obrigatório.</div>
</div>

<div class="mb-3">
    <label for="number" class="form-label">Número</label>
    <input type="text" id="number" name="number" class="form-control"
           value="{{ old('number', $customer->number ?? '') }}">
    <div class="invalid-feedback" id="numberError">Número é obrigatório.</div>
</div>

<div class="mb-3">
    <label for="complement" class="form-label">Complemento</label>
    <input type="text" id="complement" name="complement" class="form-control"
           value="{{ old('complement', $customer->complement ?? '') }}">
    <div class="invalid-feedback" id="complementError">Complemento é obrigatório.</div>
</div>

<div class="mb-3">
    <label for="neighborhood" class="form-label">Bairro</label>
    <input type="text" id="neighborhood" name="neighborhood" class="form-control"
           value="{{ old('neighborhood', $customer->neighborhood ?? '') }}">
    <div class="invalid-feedback" id="neighborhoodError">Bairro é obrigatório.</div>
</div>

<div class="mb-3">
    <label for="city" class="form-label">Cidade</label>
    <input type="text" id="city" name="city" class="form-control" value="{{ old('city', $customer->city ?? '') }}">
    <div class="invalid-feedback" id="cityError">Cidade é obrigatório.</div>
</div>

<div class="mb-3">
    <label for="state" class="form-label">Estado</label>
    <input type="text" id="state" name="state" class="form-control" value="{{ old('state', $customer->state ?? '') }}">
    <div class="invalid-feedback" id="stateError">Estado é obrigatório.</div>
</div>

<div class="mb-3">
    <label for="cellphone" class="form-label">Celular</label>
    <input type="text" name="cellphone" id="cellphone" class="form-control" value="{{ old('cellphone', $customer->cellphone ?? '')
    }}">
    <div class="invalid-feedback" id="cellphoneError">Telefone ínvalido.</div>
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" id="emailCustomer" class="form-control" value="{{ old('email', $customer->email ??
    '')
    }}">
    <div class="invalid-feedback" id="emailError">Email ínvalido.</div>
</div>

<div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" name="password" class="form-control" id="password">
    <div class="invalid-feedback" id="passwordError">Senha é obrigatória.</div>
</div>
