<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'idUser',
        'total'
    ];

    protected $primaryKey = 'idOrder';

    public function products()
    {
        return $this->belongsToMany(Product::class, 'productsPerOrder', 'idOrder', 'idProduct')
            ->select('products.name', 'productsPerOrder.productQuantity');
    }
}
