document.addEventListener('DOMContentLoaded', function () {
    // Quando o botão de criar usuário for clicado
    document.getElementById('createUserBtn').addEventListener('click', function () {
        document.getElementById('userModalLabel').textContent = 'Criar Usuário';
        document.getElementById('userForm').action = '/admin/users';  // Define a rota de criação
        document.getElementById('name').value = '';
        document.getElementById('cpf').value = '';
        document.getElementById('email').value = '';
        document.getElementById('password').required = true;  // Exige senha ao criar
        document.getElementById('password_confirmation').required = true;
        document.getElementById('is_admin').checked = false;
    });

    // Quando o botão de editar usuário for clicado
    document.querySelectorAll('.editUserBtn').forEach(function (button) {
        button.addEventListener('click', function () {

            document.getElementById('userModalLabel').textContent = 'Editar Usuário';
            document.getElementById('userForm').action = `/admin/users/${userId}`;
        });
    });
});
