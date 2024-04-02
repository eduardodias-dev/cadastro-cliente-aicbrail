<?php

namespace App\ViewModels;

abstract class BankAccountViewModel
{
    public $id;
    public $name;
    public $document;
    public $phone;
    public $emailContact;
    public $logo;
    public $softDescriptor;
    public $Address;
    public $canAccessPlatform = true;
}

class AddressViewModel{
    public $zipCode;
    public $street;
    public $number;
    public $complement;
    public $neighborhood;
    public $city;
    public $state;
}
