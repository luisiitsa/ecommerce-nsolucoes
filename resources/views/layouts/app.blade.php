<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'E-Commerce')</title>

    <!-- Inclui os assets do Bootstrap e outros arquivos via Vite -->
    @vite(['resources/js/app.js'])
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">Minha Loja</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        {{--        <div class="collapse navbar-collapse" id="navbarNav">--}}
        {{--            <ul class="navbar-nav ms-auto">--}}
        {{--                <li class="nav-item">--}}
        {{--                    <a class="nav-link active" href="{{ url('/') }}">Home</a>--}}
        {{--                </li>--}}
        {{--                <li class="nav-item">--}}
        {{--                    <a class="nav-link" href="#">Produtos</a>--}}
        {{--                </li>--}}
        {{--                <li class="nav-item">--}}
        {{--                    <a class="nav-link" href="#">Carrinho</a>--}}
        {{--                </li>--}}
        {{--                <li class="nav-item">--}}
        {{--                    <a class="nav-link" href="#">Contato</a>--}}
        {{--                </li>--}}
        {{--            </ul>--}}
        {{--        </div>--}}
    </div>
</nav>

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
