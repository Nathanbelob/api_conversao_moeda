<?php

namespace App\Http\BO;

use Illuminate\Http\Request;
use App\Models\HistoricoConversao;

class HistoricoConversaoBO
{

    public function initialize()
    {
        $idUsuario = \Auth::id();
        $historico = HistoricoConversao::where('id_usuario', $idUsuario)->orderByDesc('id')->get();

        return $historico;
    }

    public function salvaHistorico($retorno)
    {
        $retorno->id_usuario = \Auth::id();
        HistoricoConversao::create((array)$retorno);

        return $this;
    }
}
