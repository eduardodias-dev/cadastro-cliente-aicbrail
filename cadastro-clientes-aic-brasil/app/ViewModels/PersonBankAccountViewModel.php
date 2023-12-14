<?php

namespace App\ViewModels;

class PersonBankAccountViewModel extends BankAccountViewModel
{
    public $Professional;
}

class Professional {
    public $internalName; //lawyer,doctor,accountant,realtor,broker,physicalEducator,physiotherapist,others
    public $inscription;
}
