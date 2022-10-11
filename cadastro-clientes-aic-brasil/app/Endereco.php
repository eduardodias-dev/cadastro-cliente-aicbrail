<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    //
    protected $table = 'cliente_endereco';
    public $timestamps = false;
    protected $guarded = [];
}
