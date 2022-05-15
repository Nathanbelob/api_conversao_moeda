<html>
    <body>
        <p>Olá {{ $dados->usuario }}!</p>
        <p></p>
        <p>Esses sao os resultados da sua conversão realizada em {{$dados->data_hora}}.</p>
        <p>Moeda Origem: {{$dados->moeda_origem}}</p>
        <p>Moeda Destino: {{$dados->moeda_destino}}</p>
        <p>Forma Pagamento: {{$dados->forma_pagamento}}</p>
        <p>Valor para conversão: R${{$dados->valor_para_conversao}}</p>
        <p>Valor da "Moeda de destino" usado para conversão: ${{$dados->valor_moeda_conversao}}</p>
        <p>Valor comprado em "Moeda de destino": ${{$dados->valor_comprado_moeda_destino}}</p>
        <p>Taxa de pagamento: R${{$dados->taxa_conversao}}</p>
        <p>Taxa de conversão: R${{$dados->taxa_pagamento}}</p>
        <p>Valor utilizado para conversão descontando as taxas: R${{$dados->valor_usado_conversao}}</p>
        <p>Att, <br>
        Conversor de Moedas!</p>
    </body>
</html> 