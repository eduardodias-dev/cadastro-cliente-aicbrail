<div style="font-family:Arial, Helvetica, sans-serif;text-align:center; padding: 10px;max-width: 70%; margin:0 auto;">
    <img src="{{$message->embed($caminhoArquivoLogo)}}" height="100" />
    <h1 style="font-weight: 100;">Pagamento Confirmado!</h1>
    <p>
        Estamos felizes em dizer que seu <b>Pagamento foi confirmado</b> e você já pode usufruir de todos os benefícios adquiridos
        aqui na <b>AIC Brasil</b>!
    </p>
    <div style="border: 1px solid #6c97c3; border-radius: 10px; padding: 10px; text-align:left;margin-bottom: 10px;">
        <h4 style="padding-bottom: 0;">Dados da assinatura:</h4>
        <b>Pedido:</b> {{$assinatura->codigo_pacote}}<br/>
        <b>Data de emissão:</b> {{getDataPorExtenso($assinatura->adesao)}}<br/>
        <b>Titular:</b> {{$assinatura->nome_cliente}} <br>
        <b>Telefone:</b> {{$assinatura->telefone}} <br>
        <b>Endereço:</b> {{$assinatura->logradouro}}, {{$assinatura->numero}} <br>
        <b>Cidade:</b> {{$assinatura->cidade}}/{{$assinatura->estado}} <br>
        <b>CEP:</b> {{$assinatura->cep}}
    </div>
    <div style="background-color: #ddd; border-radius: 10px; padding: 10px;text-align: left;">
        Abaixo segue a apólice com os dados da sua compra.<br/>
        Quaisquer dúvida não deixe de entrar em contato pelos canais:
        <div class="email">
            <h4>Emails:</h4>
            <p>aicbrasill@gmail.com</p>
            <p>contato@aicbrasil-ies.com.br</p>
        </div>

        <div class="phone">
            <h4>Tels.:</h4>
            <p>(31) 97348-2342</p>
            <p>0800.348.2342</p>
        </div>
    </div>
</div>
