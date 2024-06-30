<div style="font-family:Arial, Helvetica, sans-serif;text-align:center; padding: 10px;max-width: 70%; margin:0 auto;">
    <img src="{{$message->embed($caminhoArquivoLogo)}}" height="100" />
    <h1 style="font-weight: 100;">Bem-vindo ao AIC BANK!</h1>
    <p>
        Estamos muito felizes em tê-lo(a) conosco, conte com a gente sempre que precisar! <br/>
    </p>
    <div style="border: 1px solid #6c97c3; border-radius: 10px; padding: 10px; text-align:left;margin-bottom: 10px;">
        <h4 style="padding-bottom: 0;">Dados do Cadastro:</h4>
        <b>Titular:</b> {{$subconta->name}} <br>
        <b>Telefone:</b> {{formatarTelefone($subconta->phone)}} <br>
        <b>Endereço:</b> {{$endereco->street}}, {{$endereco->number}} {{$endereco->complement}} <br>
        <b>Cidade:</b> {{$endereco->city}}/{{$endereco->state}} <br>
        <b>CEP:</b> {{$endereco->zipCode}}
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
