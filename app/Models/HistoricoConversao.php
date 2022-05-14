<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoConversao extends Model
{
    use HasFactory;

    protected $table = 'historico_conversao';

        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "id_usuario",
        "moeda_origem",
        "moeda_destino",
        "valor_para_conversao",
        "forma_pagamento",
        "valor_moeda_conversao",
        "valor_comprado_moeda_destino",
        "taxa_conversao",
        "taxa_pagamento",
        "valor_usado_conversao"
    ];

    public function usuario()
    {
        return $this->hasOne(User::class, 'id', 'id_usuario');
    }

          
}
