<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
	public $timestamps = false;
	
	protected $fillable = [
        'idAdministrator',
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
