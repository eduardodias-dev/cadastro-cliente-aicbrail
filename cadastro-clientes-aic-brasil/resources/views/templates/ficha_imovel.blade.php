<html>
<style>
    table {
        border-collapse: collapse;
        width: 100%;
        text-align:center;
    }

    th, td {
        border: 1px solid black;
        padding: 8px;
    }

    table.sem-borda th, table.sem-borda td  {
        border: 0;
        width: 33.3%;
    }
</style>
<body style="font-family: Arial, Helvetica, sans-serif; border: 2px solid black; padding: 25px;">
    <div style="text-align: center; width: 100%;">
        <img src="{{ storage_path('app/public/LOGO-AIC-BRASIL.png') }}" height="80" />
    </div>
    <h3 style="font-weight: 400; text-align:center;">TERMO DE VISITA E VISTORIA</h3>
    <table>
        <tbody>
            <tr>
                <td><b>AIC BRASIL – AiC BANK & IMOB</b></td>
                <td><b>CRECI no.39741, PJ no.6507</b></td>
            </tr>
            <tr>
                <td colspan="2"><b>CNPJ: 21.135.451/0001-06</b></td>
            </tr>
        </tbody>
    </table>
    <table style="margin-top: 10px;">
        <thead>
            <tr>
                <td colspan="2"><b>AGENDAMENTO DE VISITA AO(S) IMÓVEL(IS)</b></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="width: 50%;"><b>{{$visita['data']}}</b></td>
                <td style="width: 50%;">{{$visita['hora']}}</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:left !important;">
                    <b>EMPREENDIMENTO, SÍTIO (ZONA RURAL):</b><br><br>
                        {{$imovel['street'] . " " .
                         $imovel['number'] . " " . 
                         $imovel['complement'] . " - " .
                         $imovel['neighborhood']." - " .
                         $imovel['city'] . "/" .
                         $imovel['state']}}
                </td>
            </tr>
        </tbody>
    </table>
    <div style="margin-top: 10px; text-align:justify;">
        <p style="font-size: 16px">            
            AS PARTES, NA MELHOR FORMA DE DIREITO, VIDE LEI no.4.769|65 E LEI no.6.530|78, 
            CONVENCIONAM O PRESENTE, AO QUAL, COMPORÁ, O CONTRATO DE COMPRA E VENDA, A SER 
            ESTIPULADO, INCLUSIVE, VALER-SE-Á ESTE, COMO INSTRUMENTO INTEGRANTE DO 
            CONTRATO DE PRESTAÇÃO DE SERVIÇOS, QUE REGER-SE-Á, MEDIANTE AS CLÁUSULAS E 
            CONDIÇÕES ESTIPULADAS.
        </p>
    </div>
    <table style="margin-top: 10px;">
        <thead>
            <tr>
                <td colspan="2"><b>VISITANTE(S) PROMISSÁRIO(S) COMPRADOR(ES)</b></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><b>NOME</b></td>
                <td><b>CPF</b></td>
            </tr>
            @foreach($compradores as $comprador)
            <tr>
                <td>{{$comprador['nome']}}</td>
                <td>{{$comprador['cpf']}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <table style="margin-top: 10px;">
        <thead>
            <tr>
                <td colspan="2"><b>PROPRIETÁRIO(S) PROMISSÁRIO(S) VENDEDOR(ES)</b></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><b>NOME</b></td>
                <td><b>CPF</b></td>
            </tr>
            <tr>
                <td>{{strtoupper($imovel['nome_proprietario'])}}</td>
                <td>{{strtoupper($imovel['cpf_proprietario'])}}</td>
            </tr>
        </tbody>
    </table>
    <div style="margin-top: 10px;">
        <p style="font-size: 16px;text-align:justify;">            
            O PROMITENTE VENDEDOR, DECLARA SER PROPRIETÁRIO DO BEM E, O(S) PROMISSÁRIO(S) 
            COMPRADOR(ES) DECLARA(M) SOB PENA DE RESPONSABILIDADE CÍVEL|CRIMINAL, QUE 
            ESTEVE(RAM) PRESENTE(S) AD ́CORPUS NO(S) IMÓVEL(IS) ACIMA DESCRITO(S), COM O 
            INTUÍTO DE AQUISIÇÃO (COMPRA), VIDE TRANSAÇÃO IMOBILIÁRIA, INTERMEDIADA PELA 
            AiC BRASIL – AiC BANK & iMoB.
        </p>
    </div>
    <table class="sem-borda" style="margin-top: 50px; font-size: 14px;">
        <tbody>
            <tr>
                <td><b>PROPRIETÁRIO(A)</b></td>
                <td><b>CORRETOR(A) IMOBILIÁRIA</b></td>
                <td><b>VISITANTE | COMPRADOR(A)</b></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
