<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $primaryKey = 'idComment';

    protected $fillable = [
        'idUser',
        'idProduct',
        'content'
    ];

    public function replies(){
        return $this->hasMany('App\Reply') 
                    -> select('replies.idReply', 'replies.idUser', 'replies.created_at', 'replies.reply', 'users.name')
                    -> join('users', 'users.idUser', '=', 'replies.idUser');
    }
}
