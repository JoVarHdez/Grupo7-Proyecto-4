<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'idProduct';
    protected $amount = 'amount';

    public $timestamps = false;
	
	protected $fillable = [
        'description', 'name', 'price', 'active', 'amount', 'image_path',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'productsPerCategory', 'idProduct', 'idCategory');
    }

    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'productsPerCart', 'idProduct', 'idCart');
    }

    public static function get_global_rate($id)
    {
        $ratesSum = Rate::where("idProduct", $id)
                            -> sum("rate");

        $ratesCount = Rate::where("idProduct", $id)
                            -> count();
       
        if ($ratesCount > 0)
            $globalRate = $ratesSum / $ratesCount;
        else
            $globalRate = 0;

        return $globalRate;
    }

}
