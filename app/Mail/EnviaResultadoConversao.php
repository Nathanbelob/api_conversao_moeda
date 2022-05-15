<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnviaResultadoConversao extends Mailable
{
    use Queueable, SerializesModels;

    public $retorno;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($retorno)
    {
        $this->retorno = $retorno;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('conversaomoedas@conversao.com.br')
                    ->subject('Resultado Conversão Moeda')
                    ->view('mail.resultado-conversao')
                    ->with([
                        'dados' => $this->retorno
                    ]);
    }
}
