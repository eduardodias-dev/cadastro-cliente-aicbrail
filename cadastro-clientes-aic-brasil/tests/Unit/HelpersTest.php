<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class HelpersTest extends TestCase
{
    /**
     * criação de conta PF
     *
     * @return void
     */
    public function testformatCreateAccountErrorsNameWithTwoWords(){
        $errors = "Company.softDescriptor:O texto Elisa D\u00e9bora Reb n\u00e3o \u00e9 v\u00e1lido, deve conter apenas letras e n\u00fameros.";

        $result = formatCreateAccountErrors($errors);
        
        $this->assertEquals($result, "Nome para exibição na Fatura: O texto Elisa D\u00e9bora Reb n\u00e3o \u00e9 v\u00e1lido, deve conter apenas letras e n\u00fameros.");
    }

    /**
     * 
     *
     * @return void
     */
    public function testformatCreateAccountErrorsNameWithThreeWords(){
        $errors = "Company.Professional.internalName:O texto Elisa D\u00e9bora Reb n\u00e3o \u00e9 v\u00e1lido, deve conter apenas letras e n\u00fameros.";

        $result = formatCreateAccountErrors($errors);
        
        $this->assertEquals($result, "Profissão: O texto Elisa D\u00e9bora Reb n\u00e3o \u00e9 v\u00e1lido, deve conter apenas letras e n\u00fameros.");
    }

    public function testformatCreateAccountErrorsNameWithOneWords(){
        $error = "name:O texto Elisa D\u00e9bora Reb n\u00e3o \u00e9 v\u00e1lido, deve conter apenas letras e n\u00fameros.";

        $result = formatCreateAccountErrors($error);
        
        $this->assertEquals($result, "Nome: O texto Elisa D\u00e9bora Reb n\u00e3o \u00e9 v\u00e1lido, deve conter apenas letras e n\u00fameros.");
    }
}
