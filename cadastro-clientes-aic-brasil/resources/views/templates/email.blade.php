<div style="font-family:Arial, Helvetica, sans-serif;text-align:center; padding: 10px;max-width: 70%; margin:0 auto;">
    <img src="{{$message->embed($caminhoArquivoLogo)}}" height="100" />
    <h1 style="font-weight: 100;">Bem-vindo à AIC BRASIL!</h1>
    <p>
        Estamos muito felizes em tê-lo(a) conosco, conte com a gente sempre que precisar! <br/>
    </p>
    <div style="border: 1px solid #6c97c3; border-radius: 10px; padding: 10px; text-align:left;margin-bottom: 10px;">
        <h4 style="padding-bottom: 0;">Dados da assinatura:</h4>
        <b>Apólice:</b> {{$assinatura->codigo_assinatura}}<br/>
        <b>Data de emissão:</b> {{getDataPorExtenso($assinatura->adesao)}}<br/>
        <b>Titular:</b> {{$assinatura->nome_cliente}} <br>
        <b>Telefone:</b> {{$assinatura->telefone}} <br>
        <b>Endereço:</b> {{$assinatura->logradouro}}, {{$assinatura->numero}} <br>
        <b>Cidade:</b> {{$assinatura->cidade}}/{{$assinatura->estado}} <br>
        <b>CEP:</b> {{$assinatura->cep}}
    </div>
    <div style="background-color: #ddd; border-radius: 10px; padding: 10px;text-align: left;">
        Prezado(a) cliente, assim que nosso sistema registrar o pagamento, a sua <b>APÓLICE</b> de <b>ASSISTÊNCIA 24h</b> será encaminhada em teu e-mail, finalizando de fato a compra e, assim, você poderá usufruir de todos os benefícios contratados. Desde já muitíssimo obrigado.<br/>
        Quaisquer dúvida não deixe de entrar em contato pelos canais:
        <div class="email">
            <h4>Emails:</h4>
            <p>aicbrasill@gmail.com</p>
        </div>

        <div class="phone">
            <h4>Tels.:</h4>
            <p>(31) 97348-2342</p>
            <p>0800.348.2342</p>
        </div>
    </div>
</div>
