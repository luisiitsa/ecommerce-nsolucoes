@extends('layouts.admin')

@vite('resources/js/users.js')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Listagem de Usuários</h1>

            <!-- Botão de Criar Usuário -->
            <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#userModal" id="createUserBtn">
                <i class="fas fa-user-plus"></i> Criar Usuário
            </a>
        </div>

        <!-- Formulário de filtro -->
        <form action="{{ route('admin.users.index') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" name="name" class="form-control" placeholder="Filtrar por nome"
                               value="{{ request('name') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Filtrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Tabela de usuários -->
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Nome</th>
                <th>CPF</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->cpf }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <!-- Botão de editar -->
                        <a href="#" class="btn btn-sm btn-warning editUserBtn" data-id="{{ $user->id }}"
                           data-name="{{ $user->name }}" data-cpf="{{ $user->cpf }}" data-email="{{ $user->email }}"
                           data-is_admin="{{ $user->is_admin }}" data-bs-toggle="modal" data-bs-target="#userModal">
                            <i class="fas fa-edit"></i>
                        </a>

                        <!-- Botão de deletar -->
                        @if(auth()->id() !== $user->id)
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Tem certeza que deseja deletar este usuário?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Nenhum usuário encontrado.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <!-- Paginação -->
        <div class="d-flex justify-content-center">
            {{ $users->links() }}
        </div>

        <!-- Modal para Criar/Editar Usuário -->
        <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userModalLabel">Criar/Editar Usuário</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulário para Criar/Editar Usuário -->
                        <form id="userForm" action="" method="POST">
                            @csrf

                            <div id="methodField"></div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="cpf" class="form-label">CPF</label>
                                <input type="text" class="form-control" id="cpf" name="cpf" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Senha</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                       name="password_confirmation" required>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="is_admin" name="is_admin">
                                <label class="form-check-label" for="is_admin">Usuário é Admin</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
