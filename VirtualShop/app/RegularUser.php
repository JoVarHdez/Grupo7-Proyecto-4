<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegularUser extends Model
{
	protected $table = 'regularUsers';
	public $timestamps = false;
	
	protected $fillable = [
        'idRegularUser',
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
