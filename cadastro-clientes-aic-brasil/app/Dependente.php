<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dependente extends Model
{
    //
    protected $table = "dependente";
    public $timestamps = false;
    protected $guarded = [];
}
