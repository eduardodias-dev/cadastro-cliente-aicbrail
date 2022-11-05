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
