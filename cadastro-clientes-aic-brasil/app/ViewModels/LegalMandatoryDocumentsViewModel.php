<?php

namespace App\ViewModels;

class LegalMandatoryDocumentsViewModel implements IMandatoryDocumentsViewModel{

    public $Fields;
    public $Associate;
    public $Documents;
}

class LegalFields{
    public $monthlyIncome;
    public $about;
    public $socialMediaLink;
}

class AssociateViewModel{
    public $document;
    public $name;
    public $motherName;
    public $birthDate;
    public $type;
}

class LegalDocuments{
    public $Company;
    public $Documents;
}

class CompanyDocuments{
    public $lastContract;
    public $cnpjCard;
    public $electionRecord;
    public $statute;
}

class PersonalDocuments{
    public $CNH;
    public $RG;
}

class LegalCNHDocument{
    public $selfie;
    public $picture;
}

class LegalRGDocument{
    public $selfie;
    public $front;
    public $back;
}
