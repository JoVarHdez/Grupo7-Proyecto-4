<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Product;
use App\Category;
use App\Cart;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        if (Session::has('cart'))
        {
            $oldCart = Session::get('cart');
        }else
        {
            $oldCart = null;
        }
        $cartItems = new Cart($oldCart);

        // $cartItems 

    	return view('checkout', ['cartItems' => $cartItems, 'categories' => $categories]);
    }
}
