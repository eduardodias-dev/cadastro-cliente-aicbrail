<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telefone extends Model
{
    //
    protected $table = "cliente_telefone";
    public $timestamps = false;
    protected $guarded = [];
}
