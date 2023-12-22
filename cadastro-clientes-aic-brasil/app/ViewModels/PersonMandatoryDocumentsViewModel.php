<?php

namespace App\ViewModels;

class PersonMandatoryDocumentsViewModel{
    public $Fields;
    public $Documents;
}

class PersonFields{
    public $motherName;
    public $birthDate;
    public $monthlyIncome;
    public $about;
    public $socialMediaLink;
}

class PersonDocuments{
    public $Personal;
}

class PersonalDocuments {
    public $CNH;
    public $RG;
}
class PersonCNHDocument{
    public $selfie;
    public $picture;
    public $address;
}

class PersonRGDocument{
    public $selfie;
    public $front;
    public $back;
    public $address;
}
