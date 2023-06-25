<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pacote extends Model
{
    //
    protected $table = "pacote";
    protected $primaryKey = "id";
    // public $incrementing = true;
    // protected $keyType = 'string';
    //created_at, updated_at
    // public $timestamps = false;
    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'atualizado_em';
    protected $guarded = [];
}
