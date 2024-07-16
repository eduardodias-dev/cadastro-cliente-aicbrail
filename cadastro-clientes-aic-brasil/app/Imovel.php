<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ImovelVisita;

class Imovel extends Model
{
    //
    protected $table = "imovel";
    protected $primaryKey = "id";
    // public $incrementing = true;
    // protected $keyType = 'string';
    //created_at, updated_at
    // public $timestamps = false;
    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'atualizado_em';
    protected $guarded = [];

    public function visitas(){
        return $this->hasMany(ImovelVisita::class, "imovel_id", "id");
    }
}