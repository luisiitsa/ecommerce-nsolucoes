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
    resetValidation(document.getElementById('neighborhood'), 'neighborhoodError');
    resetValidation(document.getElementById('city'), 'cityError');
    resetValidation(document.getElementById('state'), 'stateError');
    resetValidation(document.getElementById('passwordCustomer'), 'passwordError');

    var cpf = document.getElementById('cpf').value;
    var uncpf = cpf.replace(/[^\d]+/g, '');
    var postaCode = document.getElementById('postal_code').value;
    var unmpostaCode = postaCode.replace(/[^\d]+/g, '');
    var cellPhoneCode = document.getElementById('cellphone').value;
    var unmcellPhone = cellPhoneCode.replace(/[^\d]+/g, '');

    document.getElementById('cpf').value = uncpf;
    document.getElementById('postal_code').value = unmpostaCode;
    document.getElementById('cellphone').value = unmcellPhone;

    // Validações personalizadas
    let nameValid = validateName(document.getElementById('name'));
    let cpfValid = validateCPF(document.getElementById('cpf').value);
    let cellphoneValid = validateCellphone(document.getElementById('cellphone'));
    let emailValid = validateEmailField(document.getElementById('emailCustomer'));
    let requiredFieldsValid = validateRequiredFields([
        { field: document.getElementById('cpf'), errorField: 'cpfError' },
        { field: document.getElementById('postal_code'), errorField: 'postalCodeError' },
        { field: document.getElementById('address'), errorField: 'addressError' },
        { field: document.getElementById('number'), errorField: 'numberError' },
        { field: document.getElementById('neighborhood'), errorField: 'neighborhoodError' },
        { field: document.getElementById('city'), errorField: 'cityError' },
        { field: document.getElementById('state'), errorField: 'stateError' },
        { field: document.getElementById('passwordCustomer'), errorField: 'passwordError' },
    ]);

    // Impede o envio se alguma validação falhar
    if (!nameValid || !cpfValid || !cellphoneValid || !emailValid || !requiredFieldsValid) {
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
