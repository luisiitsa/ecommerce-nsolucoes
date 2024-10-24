document.addEventListener('DOMContentLoaded', function () {
    // Captura os dados do carrinho da div com id="cart-data"
    const cartDataElement = document.getElementById('cart-data');
    const cart = JSON.parse(cartDataElement.getAttribute('data-cart'));

    const form = document.getElementById('freteCartForm');

    form.addEventListener('submit', async function (e) {
        e.preventDefault(); // Previne o recarregamento da página

        // Captura o CEP de destino e o tipo de frete escolhido
        const cep = document.getElementById('cepTo').value;
        const cepTo = cep.replace(/\D/g, '');
        const type = document.getElementById('type').value;

        // Verifica se o carrinho existe e contém produtos
        if (!cart || Object.keys(cart).length === 0) {
            alert('O carrinho está vazio!');
            return;
        }

        // Inicializa as variáveis de cálculo
        let totalWeight = 0;
        let totalHeight = 0;
        let total = 0;
        let totalPay = 0;
        let maxLength = 0;
        let maxWidth = 0;

        // Calcula o peso total e as dimensões combinadas
        for (const productId in cart) {
            const product = cart[productId];
            totalWeight += product.weight * product.quantity; // Soma o peso total
            totalHeight += product.height * product.quantity; // Soma a altura total
            total += product.price * product.quantity; // Soma o valor total
            maxLength = Math.max(maxLength, product.length);  // Pega o maior comprimento
            maxWidth = Math.max(maxWidth, product.width);     // Pega a maior largura
        }

        // Prepara os dados para enviar via POST
        const data = {
            cepTo: cepTo,
            weight: totalWeight,
            length: maxLength,
            height: totalHeight,
            width: maxWidth,
            type: type,
        };

        try {
            // Faz a requisição usando fetch
            const response = await fetch('/api/calculate-freight', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            });

            if (!response.ok) {
                throw new Error('Erro na requisição do frete.');
            }

            const result = await response.json();

            totalPay = parseFloat(result.valor) + parseFloat(total);

            // Exibe o resultado do frete
            document.getElementById('resultadoFrete').innerHTML = `
                <div class="alert alert-info" xmlns="http://www.w3.org/1999/html">
                    <p><strong>Valor do Produto:</strong> R$ ${total}</p>
                    <p><strong>Valor do Frete:</strong> R$ <strong id="freightValue">${result.valor}</strong></p>
                    <p><strong>Total a pagar:</strong> R$ <strong id="payment">${totalPay}</strong></p>
                    <p><strong>Prazo de Entrega:</strong> ${result.prazo} dias</p>
                </div>
            `;

        } catch (error) {
            document.getElementById('resultadoFrete').innerHTML = `
                <div class="alert alert-danger">Erro ao calcular o frete: ${error.message}</div>
            `;
        }
    });
});

document.getElementById('confirmPurchase').addEventListener('click', function () {
    let paymentMethod = document.getElementById('paymentMethod').value;
    let paymentValue = document.getElementById('payment').textContent;
    let freightValue = document.getElementById('freightValue').textContent;

    let requestData = {
        payment: paymentValue,
        freight: freightValue,
        paymentMethod: paymentMethod,
    };

    if (paymentMethod === 'CREDIT_CARD') {
        // Captura os dados do cartão
        requestData.creditCard = {
            holderName: document.getElementById('holderName').value,
            number: document.getElementById('cardNumber').value,
            expiryMonth: document.getElementById('expiryMonth').value,
            expiryYear: document.getElementById('expiryYear').value,
            ccv: document.getElementById('ccv').value,
        };
    }

    fetch('/order', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify(requestData),
    })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'Pedido criado com sucesso!') {
                alert('Pedido concluído com sucesso!');
            } else {
                alert('Erro ao processar o pedido.');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Ocorreu um erro ao processar o pedido.');
        });
});

document.getElementById('paymentMethod').addEventListener('change', function () {
    var paymentMethod = this.value;
    var creditCardFields = document.getElementById('creditCardFields');

    if (paymentMethod === 'CREDIT_CARD') {
        creditCardFields.style.display = 'block';
    } else {
        creditCardFields.style.display = 'none';
    }
});

$(document).ready(function () {
    $('#cepTo').mask('00000-000');
});
