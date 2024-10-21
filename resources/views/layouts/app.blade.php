<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'E-Commerce')</title>

    <!-- Inclui os assets do Bootstrap e outros arquivos via Vite -->
    @vite(['resources/js/app.js'])
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('app.home') }}">Minha Loja</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('app.home') }}">Produtos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('app.cart') }}">
                        Carrinho
                        @if(session()->has('cart'))
                            @php
                                $cartCount = array_sum(array_column(session('cart'), 'quantity'));
                            @endphp
                            @if($cartCount > 0)
                                <span class="badge badge-pill badge-danger">{{ $cartCount }}</span>
                            @endif
                        @endif
                    </a>
                </li>

                <!-- Verifica se o customer está logado -->
                @guest('customer')
                    <!-- Caso o customer não esteja logado -->
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
                            <i class="bi bi-person-circle"></i> Logar
                        </a>
                    </li>
                @else
                    <!-- Caso o customer esteja logado -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="customerDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> {{ explode(' ', Auth::guard('customer')->user()->name)[0] }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="customerDropdown">
                            <li><a class="dropdown-item" href="{{ route('app.customer.edit', Auth::guard('customer')
                            ->user()->id) }}">Editar
                                    Perfil</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('app.customer.logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Sair
                                </a>
                                <form id="logout-form" action="{{ route('app.customer.logout') }}" method="POST"
                                      class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<!-- Modal de Login -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulário de Login -->
                <form method="POST" action="{{ route('app.customer.login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-primary">Logar</button>
                        <a href="{{ route('app.register') }}" class="link-primary">Criar conta</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="container mt-5">
    @yield('content')
</div>

<footer class="bg-light py-4 mt-5">
    <div class="container text-center">
        <p>&copy; {{ date('Y') }} Minha Loja. Todos os direitos reservados.</p>
    </div>
</footer>

</body>
</html>
