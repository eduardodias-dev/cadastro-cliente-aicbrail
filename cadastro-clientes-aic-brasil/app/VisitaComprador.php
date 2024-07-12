<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Afiliados extends Model
{
    //
    protected $table = "visita_comprador";
    protected $primaryKey = "id";
    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'atualizado_em';
    protected $guarded = [];
}
