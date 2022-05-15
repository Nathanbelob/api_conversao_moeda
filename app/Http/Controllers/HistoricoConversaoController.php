<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ConversaoRequest; 
use App\Services\AwesomeAPIService;
use App\Http\BO\HistoricoConversaoBO;


class HistoricoConversaoController extends Controller
{
    private $code;
    
    public function __construct()
    {
        $this->code = config('httpstatus.success.ok');
        $this->middleware('auth:api');
    }

    public function initialize()
    {
        $historicoConversaoBO = new HistoricoConversaoBO();
        $retorno = $historicoConversaoBO->initialize();

        if(!$retorno)
        {
            $this->code = config('httpstatus.server_error.internal_server_error');
        }
        
        return response()->json($retorno, $this->code);
    }
}
