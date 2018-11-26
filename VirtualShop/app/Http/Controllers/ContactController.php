<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

use App\Order;
use App\Product;
use App\Cart;
use App\Category;

class ContactController extends Controller
{
    public function index()
    {
        $products = ProductController::get_active_products();
        $categories = Category::orderBy('name', 'asc')->get();
        $oldCart = Session::get('cart');
        $cartItems = new Cart($oldCart);

        return view('contact', ['products' => $products, 'categories' => $categories, 'cartItems' => $cartItems]);
    }
}
