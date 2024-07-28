<div style="font-family:Arial, Helvetica, sans-serif;text-align:center; padding: 10px;max-width: 70%; margin:0 auto;">
    <img src="{{$message->embed($caminhoArquivoLogo)}}" height="100" />
    <h1 style="font-weight: 100;">Bem-vindo à AIC Imob.!</h1>
    <p>
        Você tem uma nova visita agendada! <br/>
    </p>
    <div style="border: 1px solid #6c97c3; border-radius: 10px; padding: 10px; text-align:left;margin-bottom: 10px;">
        <h4 style="padding-bottom: 0;">Informações da Visita:</h4>
        <b>Endereço:</b> {{$visita_imovel['endereco']}} <br>
        <b>Data:</b> {{getDateTimeInBRFormat($visita_imovel['data_visita'], "UTC")}} <br>
    </div>
    <div style="background-color: #ddd; border-radius: 10px; padding: 10px;text-align: left;">
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
