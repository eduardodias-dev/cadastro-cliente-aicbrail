<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subconta extends Model
{
    protected $table = "subconta";
    protected $primaryKey = "id";
    protected $fillable = [
        'name',
        'document',
        'nameDisplay',
        'phone',
        'emailContact',
        'logo',
        'responsibleDocument',
        'typeCompany',
        'softDescriptor',
        'cnae'
    ];
    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'atualizado_em';
    protected $guarded = [];
}
