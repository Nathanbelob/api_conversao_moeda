<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ConversaoRequest; 
use App\Services\AwesomeAPIService;
use App\Http\BO\ConversaoBO;


class ConversaoController extends Controller
{
    private $taxaConversao;
    private $taxaPagamento;
    private $valorParaConversao;
    private $valorConversao;
    private $code;
    private $message;
    CONST TAXA_CARTAO = 7.63;
    CONST TAXA_BOLETO = 1.45;
    CONST CONTROLE_TAXA_PAGAMENTO = 3000;
    CONST TAXA_PAGAMNTO = 3000;
    CONST MAIOR_TAXA_PAGAMNTO = 2;
    CONST MENOR_TAXA_PAGAMNTO = 1;

    public function __construct()
    {
        $this->code = config('httpstatus.success.ok');
        $this->middleware('auth:api');
    }

    public function initialize()
    {
        $conversaoBO = new ConversaoBO();
        $retorno = $conversaoBO->initialize();

        if(!$retorno)
        {
            $this->code = config('httpstatus.server_error.internal_server_error');
        }
        
        return response()->json($retorno, $this->code);
    }

    public function conversao(ConversaoRequest $request)
    {

        $retorno = new \stdClass;
        $conversaoBO = new ConversaoBO();
        $retorno->data = $conversaoBO->conversao($request);

        if(!$retorno->data)
        {
            $this->code = config('httpstatus.server_error.internal_server_error');
            $retorno->message = 'Erro ao buscar dados.';
        }
        
        return response()->json($retorno, $this->code);
    }
}
