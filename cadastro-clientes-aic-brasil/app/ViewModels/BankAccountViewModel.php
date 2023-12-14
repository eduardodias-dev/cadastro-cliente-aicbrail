<?php

namespace App\ViewModels;

abstract class BankAccountViewModel
{
    public $name;
    public $document;
    public $phone;
    public $emailContact;
    public $logo;
    public $softDescriptor;
    public $Address;
}

class AddressViewModel{
    public $zipcode;
    public $street;
    public $number;
    public $complement;
    public $neighborhood;
    public $city;
    public $state;
}
