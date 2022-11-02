<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = "cliente";
    protected $primaryKey = "id";
    // public $incrementing = true;
    // protected $keyType = 'string';
    //created_at, updated_at
    // public $timestamps = false;
    const CREATED_AT = 'criadoEm';
    const UPDATED_AT = 'atualizadoEm';
    protected $guarded = [];
}
