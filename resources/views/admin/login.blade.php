<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Incluindo os assets do Vite -->
    @vite(['resources/js/app.js'])
</head>

<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg p-4" style="max-width: 400px; width: 100%;">
        <div class="card-body">
            <h3 class="card-title text-center mb-4">Login</h3>

            <!-- Formulário de Login -->
            <form method="POST" action="/admin/login">
                @csrf

                <!-- Campo de Usuário -->
                <div class="mb-3">
                    <label for="login" class="form-label">Usuário</label>
                    <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-person"></i>
                            </span>
                        <input type="text" class="form-control @error('login') is-invalid @enderror" id="login" name="login" value="{{ old('login') }}" required autofocus placeholder="Digite seu usuário">
                        @error('login')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <!-- Campo de Senha -->
                <div class="mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock"></i>
                            </span>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Digite sua senha">
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <!-- Botão Entrar -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Entrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Incluindo os ícones do Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</body>

</html>
