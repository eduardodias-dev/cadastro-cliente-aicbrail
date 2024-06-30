<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subconta_Profissional extends Model
{
    protected $table = "subconta_profissional";
    protected $primaryKey = "id";
    protected $fillable = [
        'internalName',
        'inscription'
    ];
    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'atualizado_em';
    protected $guarded = [];
}
