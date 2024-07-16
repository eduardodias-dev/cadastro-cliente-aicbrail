<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ImovelVisita;

class VisitaComprador extends Model
{
    //
    protected $table = "visita_comprador";
    protected $primaryKey = "id";
    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'atualizado_em';
    protected $guarded = [];

    public function visita(){
        return $this->belongsTo(ImovelVisita::class, "visita_id", "id");
    }
}
