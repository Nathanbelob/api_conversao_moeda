<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ConversaoRequest; 
use App\Services\AwesomeAPIService;
use App\Http\BO\ConversaoBO;


class ConversaoController extends Controller
{
    private $code;
    private $message;

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
