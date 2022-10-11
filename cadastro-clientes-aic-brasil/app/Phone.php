<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    //
    protected $table = "cliente_phone";
    public $timestamps = false;
    protected $guarded = [];
}
