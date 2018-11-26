<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $primaryKey = 'idRate';

    protected $fillable = [
        'idUser',
        'idProduct',
        'rate'
    ];
}
