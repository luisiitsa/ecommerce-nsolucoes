document.addEventListener('DOMContentLoaded', function () {
    // Quando o botão de criar usuário for clicado
    document.getElementById('createUserBtn').addEventListener('click', function () {
        const methodField = document.getElementById('methodField');
        methodField.innerHTML = '<input type="hidden" name="_method" value="POST">';

        document.getElementById('userModalLabel').textContent = 'Criar Usuário';
        document.getElementById('userForm').action = '/admin/users';
        document.getElementById('name').value = '';
        document.getElementById('cpf').value = '';
        document.getElementById('email').value = '';
        document.getElementById('password').required = true;
        document.getElementById('password_confirmation').required = true;
        document.getElementById('is_admin').checked = false;
    });

    // Quando o botão de editar usuário for clicado
    document.querySelectorAll('.editUserBtn').forEach(function (button) {
        button.addEventListener('click', function () {
            const userId = button.getAttribute('data-id');

            document.getElementById('userModalLabel').textContent = 'Editar Usuário';
            document.getElementById('userForm').reset();
            document.getElementById('userModalLabel').innerHTML = 'Carregando...';
            document.getElementById('userForm').action = `/admin/users/${userId}`;

            const methodField = document.getElementById('methodField');
            methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';

            fetch(`/api/users/${userId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('name').value = data.name;
                    document.getElementById('cpf').value = data.cpf;
                    document.getElementById('email').value = data.email;

                    document.getElementById('is_admin').checked = data.is_admin;

                    document.getElementById('userModalLabel').textContent = 'Editar Usuário';
                })
                .catch(error => {
                    console.error('Erro ao buscar os dados do usuário:', error);
                    document.getElementById('userModalLabel').textContent = 'Erro ao carregar os dados do usuário';
                });
        });
    });

});
