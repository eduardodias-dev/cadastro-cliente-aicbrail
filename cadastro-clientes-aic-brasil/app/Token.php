<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    //
    protected $table = 'token';
    public $timestamps = false;
    protected $primarkykey = 'access_token';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];
}
