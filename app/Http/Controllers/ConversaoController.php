<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ConversaoRequest; 
use App\Services\AwesomeAPIService;
use App\Models\HistoricoConversao;


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

    public function initialize()
    {
        $retorno = new \stdClass;
        $usuario = \Auth::user();
        $moedas = array_keys((array)(new AwesomeAPIService())->buscaMoedas());
        $retorno->usuario = $usuario;
        $retorno->moedas = $moedas;
        
        return $retorno;
    }

    public function conversao(ConversaoRequest $request)
    {
        try{
            $retorno = new \stdClass;
            $validacao = $request->validated();
            $this->defineValorCambio($request)
                 ->calculaConversao($request)
                 ->montaRetorno($retorno, $request)
                 ->salvaHistorico($retorno);
        }catch(\Exception $e)
        {
            return $e->getMessage();
        }

        return $retorno;
    }

    private function calculaConversao($request)
    {
        $taxaPagamento = $request->forma_pagamento == 'BLT' ? self::TAXA_BOLETO : self::TAXA_CARTAO;
        $this->taxaPagamento = $request->valor/100*$taxaPagamento;

        $taxaConversao = $request->valor < self::CONTROLE_TAXA_PAGAMENTO ? self::MAIOR_TAXA_PAGAMNTO : self::MENOR_TAXA_PAGAMNTO;
        $this->taxaConversao = $request->valor/100*$taxaConversao;

        $taxaTotal = $this->taxaConversao + $this->taxaPagamento;
        $this->valorParaConversao = $request->valor - $taxaTotal;

        return $this;
    }

    private function defineValorCambio($request)
    {
        $moedas = (array)(new AwesomeAPIService())->buscaMoedas();
        $this->valorConversao = $moedas[$request->moeda_destino]->high;

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

        return $this;
    }

    public function salvaHistorico($retorno)
    {
        $retorno->id_usuario = \Auth::id();
        HistoricoConversao::create((array)$retorno);

        return $this;
    }
}
