<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;

class Cart extends Model
{
    public $timestamps = false;
    public $items = null;
    public $totalQuantity = 0;
    public $totalPrice = 0;
    protected $primaryKey = 'idCart';

    
    protected $fillable = [
        'idUser',
    ];

    public function __construct($oldCart = null)
    {
        if ($oldCart != null)
        {
            $this -> items = $oldCart -> items;
            $this -> totalQuantity = $oldCart -> totalQuantity;
            $this -> totalPrice = $oldCart -> totalPrice;
            $this -> idCart = $oldCart -> idCart;
            $this -> idUser = $oldCart -> idUser;
        }
    }


    public function incrementItemQuantity($newQuantity, $id)
    {
        $this -> items[$id]['quantity'] = $newQuantity;
        $this -> items[$id]['price'] = $this -> items[$id]['item'] -> price * $this -> items[$id]['quantity'];
        $this -> totalPrice += $this -> items[$id]['item'] -> price;
    }

    public function decrementItemQuantity($newQuantity, $id)
    {
        $this -> items[$id]['quantity'] = $newQuantity;
        $this -> items[$id]['price'] = $this -> items[$id]['item'] -> price * $this -> items[$id]['quantity'];
        $this -> totalPrice -= $this -> items[$id]['item'] -> price;
    }

    public function add($item, $id)
    {
        $flag = false;
        $storedItem = ['quantity' => 0, 'price' => $item -> price, 'item' => $item];
        if ($this -> items)
        {
            if (array_key_exists($id, $this -> items))
            {
                $flag = true;
                $storedItem = $this -> items[$id];
            }
        }
        $storedItem['quantity']++;
        if ($storedItem['quantity'] > $storedItem['item'] -> amount)
        {
            $storedItem['quantity'] =  $storedItem['item'] -> amount;
        }
        $storedItem['price'] = $item -> price * $storedItem['quantity'];
        $this -> items[$id] = $storedItem;
        $this -> totalPrice += $item -> price;
        if ($flag == false)
        {
            $this -> totalQuantity++;
        }
    }

    public function insert($item, $idItem, $itemQuantity, $itemPrice)
    {
        $storedItem = ['quantity' => $itemQuantity, 'price' => $itemPrice * $itemQuantity, 'item' => $item];
        $this -> items[$idItem] = $storedItem;
        $this -> totalQuantity++;
        $this -> totalPrice +=  $itemPrice * $itemQuantity;
    }

    public function remove($item, $id)
    {
        $this -> totalPrice -= $item -> price;
        $this -> totalQuantity--;
        unset($this -> items[$id]);
    }


    public static function json_key_exists($id, $json)
    {
        for ($i = 0; $i < count($json); $i++)
        {
            if ($id == $json[$i]['idProduct'])
            {
                return $i;
            }
        }
        return -1;
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'productsPerCart', 'idCart', 'idProduct');
    }


}
