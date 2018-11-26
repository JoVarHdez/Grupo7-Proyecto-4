<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $primaryKey = 'idReply';

    protected $fillable = [
        'comment_idComment',
        'idUser',
        'reply'
    ];
}
