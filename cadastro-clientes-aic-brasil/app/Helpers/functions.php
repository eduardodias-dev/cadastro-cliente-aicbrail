<?php

function getClientStatusDescription($value){
    $description = 'Indefinida';

    switch(strtolower($value)){
        case 'active':
            $description = 'Ativo';
            break;
        case 'inactive':
        	$description = 'Inativo';
            break;
        case 'delayed':
            $description = 'Pagamento Atrasado';
            break;
        case 'withoutSubscriptionOrCharge':
            $description = 'Não possui assinatura';
            break;
    }

    return $description;
}

function getSubscriptionStatusDescription($value){
    $description = 'Indefinida';

    switch(strtolower($value)){
        case 'active':
            $description = 'Ativa';
            break;
        case 'canceled':
        	$description = 'Cancelada';
            break;
        case 'closed':
            $description = 'Encerrada';
            break;
        case 'stopped':
            $description = 'Interrompida';
            break;
    }

    return $description;
}

function getPeriodicity($value){
    $description = 'Indefinido';

    switch(strtolower($value)){
        case 'monthly':
            $description = 'Mensal';
            break;
        case 'yearly':
        	$description = 'Anual';
            break;
        case 'daily':
            $description = 'Diário';
            break;

    }

    return $description;

}

function getDateInBRFormat(string $date){
    $date = date_create($date);

    return date_format($date->setTimezone(new DateTimeZone("GMT-03:00")), 'd/m/Y');
}

function getDateTimeInBRFormat(string $date){
    $date = date_create($date);

    return date_format($date->setTimezone(new DateTimeZone("GMT-03:00")), 'd/m/Y H:i:s');
}

function getRetorno($jsonResult){
    $arrResult = json_decode($jsonResult['resultado'], true);

    return isset($arrResult['retorno']) ? $arrResult['retorno'] : "";
}

function printEstadosAsOptions(){
    $estados = [
        'AC' => 'Acre',
        'AL' => 'Alagoas',
        'AM' => 'Amazonas',
        'AP' => 'Amapá',
        'BA' => 'Bahia',
        'CE' => 'Ceará',
        'DF' => 'Distrito Federal',
        'ES' => 'Espirito Santo',
        'GO' => 'Goiás',
        'MA' => 'Maranhão',
        'MT' => 'Mato Grosso',
        'MS' => 'Mato Grosso do Sul',
        'MG' => 'Minas Gerais',
        'PA' => 'Pará',
        'PB' => 'Paraíba',
        'PR' => 'Paraná',
        'PE' => 'Pernambuco',
        'PI' => 'Piauí',
        'RJ' => 'Rio de Janeiro',
        'RN' => 'Rio Grande do Norte',
        'RS' => 'Rio Grande do Sul',
        'RO' => 'Rondonia',
        'RR' => 'Roraima',
        'SC' => 'Santa Catarina',
        'SP' => 'São Paulo',
        'TO' => 'Tocantins',
    ];

    foreach($estados as $sigla => $nome){
        print "<option value='$sigla'>$nome</option>";
    }
}

function format_number($number){
    $formatted = number_format($number, 2, ',', '.');

    return $formatted;
}

function removeSpecialCharacters($val){
    $cleaned = preg_replace('/[^a-zA-Z0-9]/', '', $val);

    return $cleaned;
}

function getExpiresAt($data){
    $arrayData = explode('/', $data, 2);
    $year = "20".$arrayData[1];
    $month = $arrayData[0];

    return $year.'-'.$month;
}

function getClassByStatus($status){
    $className = "";
    switch($status){
        case 'pendente':
            $className = 'text-warning';
            break;
        case 'ativo':
        case 'ativa':
            $className = 'text-success';
            break;
        case 'cancelada':
        case 'atrasada':
            $className = 'text-danger';
            break;
        default:
            $className = 'text-info';
    }

    return $className;
}

function getValorEmReal($val){
    $strFormatted = number_format($val, 2, ',', '.');

    return "R$ ".$strFormatted;
}

function clean($string) {
    $string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.
    $string = str_replace('-', '', $string); // Replaces all spaces with hyphens.

    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

function getDataPorExtenso($date){
    $date = getDateInBRFormat($date);
    $arrDate = explode('/', $date);

    $month = getMonthInPTBr($arrDate[1]);

    return $arrDate[0].' de '.$month.' de '.$arrDate[2];
}

function getMonthInPTBr($monthNumber)
{
    $monthInt = intval($monthNumber);
    $monthName = '';
    switch($monthInt){
        case 1:
            $monthName = 'Janeiro';
            break;
        case 2:
            $monthName = 'Fevereiro';
            break;
        case 3:
            $monthName = 'Março';
            break;
        case 4:
            $monthName = 'Abril';
            break;
        case 5:
            $monthName = 'Maio';
            break;
        case 6:
            $monthName = 'Junho';
            break;
        case 7:
            $monthName = 'Julho';
            break;
        case 8:
            $monthName = 'Agosto';
            break;
        case 9:
            $monthName = 'Setembro';
            break;
        case 10:
            $monthName = 'Outubro';
            break;
        case 11:
            $monthName = 'Novembro';
            break;
        case 12:
            $monthName = 'Dezembro';
            break;
    }

    return $monthName;
}
