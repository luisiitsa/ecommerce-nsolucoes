document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('freteForm');
    form.addEventListener('submit', async function (e) {
        e.preventDefault(); // Previne o recarregamento da página

        // Captura os valores dos inputs
        const cep = document.getElementById('cepTo').value;
        const cepTo = cep.replace(/\D/g, '');
        const weight = document.getElementById('weight').value;
        const length = document.getElementById('length').value;
        const height = document.getElementById('height').value;
        const width = document.getElementById('width').value;
        const type = document.getElementById('type').value;

        // Cria o objeto com os dados a serem enviados
        const data = {
            cepTo: cepTo,
            weight: weight,
            length: length,
            height: height,
            width: width,
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

            // Verifica se a requisição foi bem-sucedida
            if (!response.ok) {
                throw new Error('Erro na requisição do frete.');
            }

            const result = await response.json();

            // Exibe o resultado do frete
            document.getElementById('resultadoFrete').innerHTML = `
                    <div class="alert alert-info">
                        <p><strong>Valor do Frete:</strong> R$ ${result.valor}</p>
                        <p><strong>Prazo de Entrega:</strong> ${result.prazo} dias</p>
                    </div>
                `;

        } catch (error) {
            // Caso aconteça algum erro
            document.getElementById('resultadoFrete').innerHTML = `
                    <div class="alert alert-danger">Erro ao calcular o frete: ${error.message}</div>
                `;
        }
    });
});

$(document).ready(function () {
    $('#cepTo').mask('00000-000');
});
