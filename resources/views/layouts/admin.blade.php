<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Inclua o CSS compilado pelo Vite -->
    @vite(['resources/js/app.js'])
    <head>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    </head>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">NSoluções</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin') ? 'active' : '' }}" aria-current="page" href="{{
                    route('admin.home') }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Home">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/products') ? 'active' : '' }}" href="{{ route
                    ('admin.products.index') }}"
                       data-bs-toggle="tooltip" data-bs-placement="bottom" title="Produtos">
                        <i class="fas fa-box-open"></i>
                    </a>
                </li>
                @if (auth()->user() && auth()->user()->isAdmin())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}" href="{{ route
                        ('admin.users.index')
                         }}"
                           data-bs-toggle="tooltip" data-bs-placement="bottom" title="Usuários">
                            <i class="fas fa-users"></i>
                        </a>
                    </li>
                @endif
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <form action="admin/logout" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Logout">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    @yield('content')
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

</body>
</html>
