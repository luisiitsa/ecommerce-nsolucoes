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

$(document).ready(function () {
    $('#cpf').mask('000.000.000-00');
});

$('#userForm').on('submit', function (e) {
    var cpf = $('#cpf').val();
    var email = $('#email').val();

    // Remove mask for CPF validation and submission
    var unmaskedCpf = cpf.replace(/[^\d]+/g, '');

    // Validate CPF
    if (!validateCPF(unmaskedCpf)) {
        alert('CPF inválido!');
        e.preventDefault(); // Prevent form submission
        return false;
    }

    // Validate email
    if (!validateEmail(email)) {
        alert('E-mail inválido!');
        e.preventDefault(); // Prevent form submission
        return false;
    }

    // Validate passwords
    if (!validatePasswords()) {
        e.preventDefault(); // Prevent form submission if passwords are invalid
        return false;
    }

    // If all fields are valid, update CPF value without mask before submission
    $('#cpf').val(unmaskedCpf);
});

// CPF validation function
function validateCPF(cpf) {
    cpf = cpf.replace(/[^\d]+/g, ''); // Remove non-numeric characters
    if (cpf == '') return false;

    // Invalid known CPFs
    if (cpf.length != 11 ||
        cpf == '00000000000' ||
        cpf == '11111111111' ||
        cpf == '22222222222' ||
        cpf == '33333333333' ||
        cpf == '44444444444' ||
        cpf == '55555555555' ||
        cpf == '66666666666' ||
        cpf == '77777777777' ||
        cpf == '88888888888' ||
        cpf == '99999999999')
        return false;

    // Validate first check digit
    let sum = 0;
    let remainder;
    for (let i = 1; i <= 9; i++) sum = sum + parseInt(cpf.substring(i - 1, i)) * (
        11 - i
    );
    remainder = (
        sum * 10
    ) % 11;
    if ((
        remainder == 10
    ) || (
        remainder == 11
    )) remainder = 0;
    if (remainder != parseInt(cpf.substring(9, 10))) return false;

    // Validate second check digit
    sum = 0;
    for (let i = 1; i <= 10; i++) sum = sum + parseInt(cpf.substring(i - 1, i)) * (
        12 - i
    );
    remainder = (
        sum * 10
    ) % 11;
    if ((
        remainder == 10
    ) || (
        remainder == 11
    )) remainder = 0;
    if (remainder != parseInt(cpf.substring(10, 11))) return false;

    return true;
}

// Email validation function
function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Password validation function
function validatePasswords() {
    var password = $('#password').val();
    var confirmPassword = $('#password_confirmation').val();

    // Check if passwords match
    if (password !== confirmPassword) {
        alert('As senhas não coincidem!');
        return false;
    }

    // Check if password has at least 8 characters
    if (password.length < 8) {
        alert('A senha deve ter no mínimo 8 caracteres!');
        return false;
    }

    // Check if password contains at least one uppercase letter
    const uppercaseRegex = /[A-Z]/;
    if (!uppercaseRegex.test(password)) {
        alert('A senha deve conter pelo menos uma letra maiúscula!');
        return false;
    }

    return true;
}
