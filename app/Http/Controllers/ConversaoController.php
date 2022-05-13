<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ConversaoRequest; 


class ConversaoController extends Controller
{
    private $taxaConversao;
    private $taxaPagamento;
    private $valorParaConversao;
    private $valorConversao;
    CONST TAXA_CARTAO = 7.63;
    CONST TAXA_BOLETO = 1.45;
    CONST CONTROLE_TAXA_PAGAMENTO = 3000;
    CONST TAXA_PAGAMNTO = 3000;
    CONST MAIOR_TAXA_PAGAMNTO = 2;
    CONST MENOR_TAXA_PAGAMNTO = 1;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function conversao(ConversaoRequest $request) : object
    {
        $retorno = new \stdClass;
        $validacao = $request->validated();
        $this->valorConversao = 5.3;//pegar da api de conversao
        $this->calculaConversao($request->forma_pagamento, $request->valor)
             ->montaRetorno($retorno, $request);

        return $retorno;
    }

    private function calculaConversao(String $formaPagamento, float $valor)
    {
        $taxaPagamento = $formaPagamento == 'BLT' ? self::TAXA_BOLETO : self::TAXA_CARTAO;
        $this->taxaPagamento = $valor/100*$taxaPagamento;

        $taxaConversao = $valor < self::CONTROLE_TAXA_PAGAMENTO ? self::MAIOR_TAXA_PAGAMNTO : self::MENOR_TAXA_PAGAMNTO;
        $this->taxaConversao = $valor/100*$taxaConversao;

        $taxaTotal = $this->taxaConversao + $this->taxaPagamento;
        $this->valorParaConversao = $valor - $taxaTotal;

        return $this;
    }

    private function montaRetorno(&$retorno, $request)
    {
        $retorno->moeda_origem = $request->moeda_origem;
        $retorno->moeda_destino = $request->moeda_destino;
        $retorno->valor_para_conversao = $request->valor;
        $retorno->forma_pagamento = $request->forma_pagamento == 'BLT' ? 'Boleto' : 'Cartão de Crédito';
        $retorno->valor_moeda_conversao = round($this->valorConversao, 2);
        $retorno->valor_comprado_moeda_destino = round($this->valorParaConversao/$this->valorConversao, 2);
        $retorno->taxa_conversao = $this->taxaConversao;
        $retorno->taxa_pagamento = $this->taxaPagamento;
        $retorno->valor_usado_conversao = $this->valorParaConversao;
    }
}
