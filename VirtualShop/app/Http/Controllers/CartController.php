<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;
use App\Cart;
use App\Product;

class CartController extends Controller
{
    public function delete(Request $request, $id)
    {
        $oldcart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart ($oldcart);
        $product = Product::find($id);
        $cart -> remove($product, $product -> idProduct);

        if (Auth::check())
        {
            $cartId = Cart::where('idUser', Auth::id()) -> first();
            $idCart = $cartId['idCart'];
            
         DB::table('productsPerCart') ->join('carts', 'carts.idCart', '=', 'productsPerCart.idCart')
                                     -> where('productsPerCart.idProduct', $product -> idProduct)
                                     -> where('carts.idUser', Auth::id())
                                     -> where('carts.idCart', $idCart)
                                     -> delete();
        //$product -> carts() -> detach();
           // $cart -> products() -> detach($product -> idProduct);
        }

        $request -> session() -> put('cart', $cart);

        DB::table('productsPerCart') -> where('idProduct', '$id') -> delete();
        return redirect() -> back();
    }

    public function incrementItemQuantity(Request $request)
    {
        $oldcart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart ($oldcart);
        $cart -> incrementItemQuantity($request -> input('value'), $request -> input('idProduct'));
        $request -> session() -> put('cart', $cart);

        $done = array(
            "msg" => "done",
            "totalPrice" => $cart -> totalPrice
        );
        return \Response::json($done); 
    }

    public function decrementItemQuantity(Request $request)
    {
        $oldcart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart ($oldcart);

        $cart -> decrementItemQuantity($request -> input('value'), $request -> input('idProduct'));

        $request -> session() -> put('cart', $cart);

        $done = array(
            "msg" => "done",
            "totalPrice" => $cart -> totalPrice
        );
        return \Response::json($done); 
    }
}
