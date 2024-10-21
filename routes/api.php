<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware([AuthAdmin::class, 'web'])->group(function () {
    Route::get('/users/{user}', [UserController::class, 'show'])->name('api.users.show');


    Route::post('/calculate-freight', function (Request $request) {
        // Captura os dados do formulário
        $cepDestino = $request->input('cepTo');
        $peso = $request->input('weight');
        $comprimento = $request->input('length');
        $altura = $request->input('height');
        $largura = $request->input('width');
        $tipoFrete = $request->input('type');

        // Dados da requisição SOAP
        $params = array(
            'nCdEmpresa' => '', // Se você tiver contrato com os Correios, coloque o código aqui
            'sDsSenha' => '', // Senha do contrato, deixe vazio se não tiver contrato
            'nCdServico' => $tipoFrete, // Código do serviço: PAC ou SEDEX
            'sCepOrigem' => '38010100', // CEP de origem (fixo, por exemplo)
            'sCepDestino' => $cepDestino, // CEP de destino
            'nVlPeso' => $peso, // weight do produto
            'nCdFormato' => '1', // Formato da encomenda: 1 = Caixa/Pacote
            'nVlComprimento' => $comprimento, // length em cm
            'nVlAltura' => $altura, // height em cm
            'nVlLargura' => $largura, // width em cm
            'nVlDiametro' => '0', // Diâmetro, se for aplicável
            'sCdMaoPropria' => 'N', // Mão própria (N ou S)
            'nVlValorDeclarado' => '0', // Valor declarado
            'sCdAvisoRecebimento' => 'N', // Aviso de recebimento (N ou S)
        );


        try {
            // Consumindo a API dos Correios (SOAP)
            $client = new SoapClient('http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx?wsdl');
            $result = $client->CalcPrecoPrazo($params);
            $frete = $result->CalcPrecoPrazoResult->Servicos->cServico;

            // Retorna o valor e prazo de entrega em formato JSON
            return response()->json([
                'valor' => $frete->Valor,
                'prazo' => $frete->PrazoEntrega
            ]);
        } catch (Exception $e) {
            // Em caso de erro, retorna uma mensagem de erro
            return response()->json(['error' => 'Erro ao calcular o frete'], 500);
        }
    });
});
