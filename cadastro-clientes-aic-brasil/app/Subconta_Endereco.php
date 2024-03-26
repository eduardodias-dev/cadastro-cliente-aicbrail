<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subconta_Endereco extends Model
{
    protected $table = "subconta_endereco";
    protected $primaryKey = "id";
    protected $fillable = [
        'zipCode',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state'
    ];
    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'atualizado_em';
    protected $guarded = [];

}
