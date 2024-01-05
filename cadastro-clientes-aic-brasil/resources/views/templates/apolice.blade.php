<body style="font-family: Arial, Helvetica, sans-serif; border: 2px solid black; padding: 10px;">
    <div style="text-align:center; display: flex; justify-content: space-between; align-items: center; padding: 10px;">
        <!-- <img src="/site/img/LOGO-AIC-BRASIL.png" height="120" /> -->
        <h1 style="font-weight: 100;">APÓLICE DE ASSISTÊNCIA 24h</h1>
    </div>
    <hr/>
    <h3 style="font-weight: 100; text-align: center;margin-bottom:5px;padding-bottom:0;">
        Dados Cadastrais
    </h3>
    <table style="width: 100%; border: 1px solid black; margin-bottom: 5px;font-size: 12px;padding:0;">
        <thead>
            <tr style="background-color: grey;">
                <th align="left" colspan="2">Dados da Apólice</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><b>APÓLICE:</b> {{$assinatura->codigo_assinatura}}</td>
                <td><b>DATA DE EMISSÃO:</b> {{getDataPorExtenso($assinatura->adesao)}}</td>
            </tr>
            <tr>
                <td><b>{{$assinatura->info_adicional}}</b></td>
            </tr>
        </tbody>
    </table>
    <table style="width: 100%; border: 1px solid black; font-size: 12px;">
        <thead>
            <tr style="background: grey;">
                <th align="left">DADOS CADASTRAIS</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <b>NOME:</b> {{$assinatura->nome_cliente}} <br>
                    <b>CPF/CNPJ:</b> {{$assinatura->documento}} <br>
                    <b>TELEFONE:</b> {{$assinatura->telefone}} <br>
                    <b>ENDEREÇO:</b> {{$assinatura->logradouro}}, {{$assinatura->numero}} <br>
                    <b>CIDADE:</b> {{$assinatura->cidade}}/{{$assinatura->estado}} <br>
                    <b>CEP:</b> {{$assinatura->cep}}
                </td>
            </tr>
        </tbody>
    </table>
    @if(count($adicionais) > 0)
    <h3 style="font-weight: 100; text-align: center; margin-bottom:5px;padding-bottom:0;">
        PRODUTOS CONTRATADOS
    </h3>
    <table style="width: 100%; border-top: 2px solid black; margin-bottom: 10px;font-size: 12px;">
        <thead>
            <tr>
                <th align="left">CÓD.</th>
                <th align="left">PRODUTO</th>
                <th align="left">VALOR</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($adicionais as $adicional)
                <tr>
                    <td>{{str_pad($adicional->adicional_id, 5, '0', STR_PAD_LEFT)}}</td>
                    <td>{{$adicional->nome_adicional}}</td>
                    <td>{{getValorEmReal($adicional->valor)}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif
    <hr/>
    <div style="margin-top: 10px;">
        <h2 style="font-weight: lighter;">Importante:</h2>
        <p style="font-size: 12px">
            LEI GERAL DE PROTEÇÃO DE DADOS PESSOAIS (LGPD)
            A AIC Brasil e empresas do seu grupo econômico tem o compromisso de proteger a sua privacidade e respeitar os seus direitos de
            confidencialidade e proteção de dados nos termos das leis e regulamentos aplicáveis.
            O Proponente/Segurado está ciente que a AIC tratará os dados, bem como poderá compartilhar com prestadores de serviços,
            resseguradores, cosseguradores e órgãos reguladores, com a finalidade de cumprimento de suas obrigações legais e contratuais ou conforme
            permitido pela legislação aplicável.
            Para saber mais sobre o tratamento de dados pessoais pela AIC Brasil, acesse nossa Política de Privacidade disponível em
            https://aicbrasill.com.br/
        </p>
    </div>
</body>
</html>
