<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoricoConversaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historico_conversao', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_usuario')->unsigned();
            $table->string('moeda_origem', 6);
            $table->string('moeda_destino', 6);
            $table->decimal('valor_para_conversao', 8,2);
            $table->string('forma_pagamento', 20);
            $table->decimal('valor_moeda_conversao', 4,2);
            $table->decimal('valor_comprado_moeda_destino', 8,2);
            $table->decimal('taxa_conversao', 4,2);
            $table->decimal('taxa_pagamento', 4,2);
            $table->decimal('valor_usado_conversao', 8,2);

            $table->foreign('id_usuario')->references('id')->on('users');
            $table->timestamps();
        });

        // {
        //     "moeda_origem": "BRL",
        //     "moeda_destino": "CAD",
        //     "valor_para_conversao": 5000,
        //     "forma_pagamento": "Boleto",
        //     "valor_moeda_conversao": 3.97,
        //     "valor_comprado_moeda_destino": 1229.7,
        //     "taxa_conversao": 50,
        //     "taxa_pagamento": 72.5,
        //     "valor_usado_conversao": 4877.5
        //   }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historico_conversao');
    }
}
