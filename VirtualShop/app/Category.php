<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	public $timestamps = false;
    
    
	protected $fillable = [
        'name',
    ];

    protected $primaryKey = 'idCategory';

    public function products()
    {
        return $this
                ->belongsToMany(Product::class, 'productsPerCategory', 'idCategory', 'idProduct')
                ->where('active', 1);
    }

}
