document.getElementById('postal_code').addEventListener('blur', function () {
    let cep = this.value.replace(/\D/g, '');  // Remove qualquer caractere não numérico

    if (cep.length === 8) {
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if (!data.erro) {
                    // Preenche os campos com os dados retornados
                    document.getElementById('address').value = data.logradouro;
                    document.getElementById('neighborhood').value = data.bairro;
                    document.getElementById('city').value = data.localidade;
                    document.getElementById('state').value = data.uf;
                } else {
                    alert('CEP não encontrado!');
                }
            })
            .catch(error => {
                alert('Erro ao buscar o CEP. Tente novamente.');
                console.error('Erro:', error);
            });
    } else {
        alert('Formato de CEP inválido!');
    }
});

$(document).ready(function () {
    $('#postal_code').mask('00000-000');
    $('#cellphone').mask('(00) 0 0000-0000');
});

document.getElementById('customerForm').addEventListener('submit', function (event) {
    // Reseta validações anteriores
    resetValidation(document.getElementById('name'), 'nameError');
    resetValidation(document.getElementById('cellphone'), 'cellphoneError');
    resetValidation(document.getElementById('emailCustomer'), 'emailError');
    resetValidation(document.getElementById('cpf'), 'cpfError');
    resetValidation(document.getElementById('postal_code'), 'postalCodeError');
    resetValidation(document.getElementById('address'), 'addressError');
    resetValidation(document.getElementById('number'), 'numberError');
    resetValidation(document.getElementById('complement'), 'complementError');
    resetValidation(document.getElementById('neighborhood'), 'neighborhoodError');
    resetValidation(document.getElementById('city'), 'cityError');
    resetValidation(document.getElementById('state'), 'stateError');
    resetValidation(document.getElementById('password'), 'passwordError');

    // Validações personalizadas
    let nameValid = validateName(document.getElementById('name'));
    let cellphoneValid = validateCellphone(document.getElementById('cellphone'));
    let emailValid = validateEmailField(document.getElementById('emailCustomer'));
    let requiredFieldsValid = validateRequiredFields([
        { field: document.getElementById('cpf'), errorField: 'cpfError' },
        { field: document.getElementById('postal_code'), errorField: 'postalCodeError' },
        { field: document.getElementById('address'), errorField: 'addressError' },
        { field: document.getElementById('number'), errorField: 'numberError' },
        { field: document.getElementById('complement'), errorField: 'complementError' },
        { field: document.getElementById('neighborhood'), errorField: 'neighborhoodError' },
        { field: document.getElementById('city'), errorField: 'cityError' },
        { field: document.getElementById('state'), errorField: 'stateError' },
        { field: document.getElementById('password'), errorField: 'passwordError' },
    ]);

    // Impede o envio se alguma validação falhar
    if (!nameValid || !cellphoneValid || !emailValid || !requiredFieldsValid) {
        event.preventDefault();
    }
});

// Função para resetar a validação de um campo
function resetValidation(field, errorFieldId) {
    let errorField = document.getElementById(errorFieldId);
    errorField.style.display = 'none';
    field.classList.remove('is-invalid');
}

// Função para validar o nome
function validateName(nameField) {
    let name = nameField.value.trim();
    let nameError = document.getElementById('nameError');

    if (name.length < 3) {
        nameError.style.display = 'block';
        nameField.classList.add('is-invalid');
        return false;
    }
    return true;
}

// Função para validar o celular
function validateCellphone(cellphoneField) {
    let cellphone = cellphoneField.value.replace(/\D/g, '');  // Remove a máscara, deixando só números
    let cellphoneError = document.getElementById('cellphoneError');

    if (cellphone.length !== 11) {
        cellphoneError.style.display = 'block';
        cellphoneField.classList.add('is-invalid');
        return false;
    }
    return true;
}

// Função para validar o email
function validateEmailField(emailField) {
    let email = emailField.value.trim();
    let emailError = document.getElementById('emailError');

    if (!validateEmail(email)) {
        emailError.style.display = 'block';
        emailField.classList.add('is-invalid');
        return false;
    }
    return true;
}

// Função de validação de email
function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Função para validar campos obrigatórios
function validateRequiredFields(fields) {
    let allValid = true;

    fields.forEach(function (fieldObj) {
        let field = fieldObj.field;
        let errorField = document.getElementById(fieldObj.errorField);

        if (field.value.trim() === '') {
            errorField.style.display = 'block';
            field.classList.add('is-invalid');
            allValid = false;
        }
    });

    return allValid;
}
