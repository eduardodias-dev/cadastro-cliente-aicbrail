<?php

namespace App\Services;

use App\Subconta;
use App\Subconta_Endereco;
use App\Subconta_Profissional;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\ViewModels\LegalBankAccountViewModel;
use App\ViewModels\PersonBankAccountViewModel;

class SubcontaDBService
{
    public function AddSubcontaPJ(LegalBankAccountViewModel $accountViewModel)
    {
        DB::beginTransaction();

        try{
            $subconta = new Subconta();
            $subconta->name = $accountViewModel->name;
            $subconta->document = $accountViewModel->document;
            $subconta->phone = $accountViewModel->phone;
            $subconta->emailContact = $accountViewModel->emailContact;
            $subconta->logo = $accountViewModel->logo;
            $subconta->softDescriptor = $accountViewModel->softDescriptor;
            $subconta->nameDisplay = $accountViewModel->nameDisplay;
            $subconta->responsibleDocument = $accountViewModel->responsibleDocument;
            $subconta->typeCompany = $accountViewModel->typeCompany;
            $subconta->cnae = $accountViewModel->cnae;
            $subconta->save();

            $address = $this->CriarSubcontaEndereco($accountViewModel->Address);

            $address->subconta_id = $subconta->id;
            $address->save();

            DB::commit();

            return $subconta->id;
        }
        catch(Exception $e)
        {
            DB::rollBack();
            Log::error("Erro ao adicionar conta PJ\n: ".$e->getMessage());
        }

        return 0;
    }

    public function AddSubcontaPF(PersonBankAccountViewModel $accountViewModel)
    {
        DB::beginTransaction();

        try{
            $subconta = new Subconta();
            $subconta->name = $accountViewModel->name;
            $subconta->document = $accountViewModel->document;
            $subconta->phone = $accountViewModel->phone;
            $subconta->emailContact = $accountViewModel->emailContact;
            $subconta->logo = $accountViewModel->logo;
            $subconta->softDescriptor = $accountViewModel->softDescriptor;
            $subconta->galaxPayId = $accountViewModel->galaxPayId;
            $subconta->galaxId = $accountViewModel->galaxId;
            $subconta->galaxHash = $accountViewModel->galaxHash;
            
            $subconta->save();

            $address = $this->CriarSubcontaEndereco($accountViewModel->Address);
            $address->subconta_id = $subconta->id;
            $address->save();

            $profissional = new Subconta_Profissional();
            $profissional->internalName = $accountViewModel->Professional['internalName'];
            $profissional->inscription = $accountViewModel->Professional['inscription'];;

            $profissional->subconta_id = $subconta->id;
            $profissional->save();

            DB::commit();

            return $subconta->id;
        }
        catch(Exception $e)
        {
            DB::rollBack();
            Log::error("Erro ao adicionar conta PJ\n: ".$e->getMessage());

        }

        return 0;
    }

    private function CriarSubcontaEndereco($addressViewModel)
    {
        $address = new Subconta_Endereco();
        $address->zipCode = $addressViewModel['zipCode'];
        $address->street = $addressViewModel['street'];
        $address->number = $addressViewModel['number'];
        $address->complement = $addressViewModel['complement'];
        $address->neighborhood = $addressViewModel['neighborhood'];
        $address->city = $addressViewModel['city'];
        $address->state = $addressViewModel['state'];

        return $address;
    }
}
