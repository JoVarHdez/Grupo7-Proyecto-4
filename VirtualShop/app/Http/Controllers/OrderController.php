<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;

use App\Order;
use App\Product;
use App\Cart;
use App\Category;

class OrderController extends Controller
{
    public function index()
    {
        $products = ProductController::get_active_products();
        $categories = Category::orderBy('name', 'asc')->get();
        $oldCart = Session::get('cart');
        $cartItems = new Cart($oldCart);

        return view('payment', ['products' => $products, 'categories' => $categories, 'cartItems' => $cartItems]);
    }

    public function store(Request $request)
    {

        $category = Category::where('name', 'LIKE', request('category'))->get();
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        
        if ($cart -> totalQuantity > 0)
        {
            $order = Order::create([
                'idUser' => Auth::id(),
                'total' =>  $cart ->totalPrice
            ]);
            
            foreach($cart -> items as $item)
            {
                $product =  DB::table('products')
                        ->where('idProduct', $item['item'] -> idProduct)
                        -> first();

                
                if ($item['quantity'] > 0 && $item['item'] -> amount > 0 && $item['quantity'] <= $product -> amount)
                {
                    Order::find($order->idOrder)->products()->attach($item['item'] -> idProduct, ["productQuantity" => $item['quantity']]);
                    $item['item'] -> amount -= $item['quantity'];
                    DB::table('products')
                        ->where('idProduct', $item['item'] -> idProduct)
                        ->update(['amount' =>  $item['item'] -> amount]);

                    DB::table('productsPerCart')
                        ->where('idProduct', $item['item'] -> idProduct)
                        -> where('idCart', $cart -> idCart)
                        -> delete();

                    Session::forget('cart');
                }
                else
                {
                    return back()->withErrors([
                        'message' => 'The quantity of an item is not complying with the quantity of the item available in stock'
                    ]);
                }
            }

            session()->flash('message', 'Order created');
            

            return redirect('/index');
        }
        return back()->withErrors([
            'message' => 'There are no items in your Cart.'
        ]);
    }

    public function show()
    {
        
        $products = DB::table('products') 
                        -> select('products.name', 'orders.idOrder', 'products.idProduct')
                        ->join('productsPerOrder', 'products.idProduct', '=', 'productsPerOrder.idProduct')
                        -> join('orders', 'productsPerOrder.idOrder', '=', 'orders.idOrder') 
                        -> get();

        //$products = DB::table('products')->paginate(15);
        $categories = Category::orderBy('name', 'asc')->get();
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cartItems = new Cart($oldCart);
        
        $orders = Order::where('idUser', Auth::id()) -> get();


        if (Auth::check())
        {
            $orders = Order::where('idUser', Auth::id()) -> get();
            return view('order', ['products' => $products, 'categories' => $categories, 'cartItems' => $cartItems, 'orders' => $orders]);
        }

        else
            return view('/index', ['products' => $products, 'categories' => $categories, 'cartItems' => $cartItems,]);
    }

    public function search(Request $request)
    {

        $this->validate(request(), [
            'orderId' => 'required|numeric|min:0'
        ]);
                $products = DB::table('products') 
                        -> select('products.name', 'orders.idOrder', 'products.idProduct')
                        ->join('productsPerOrder', 'products.idProduct', '=', 'productsPerOrder.idProduct')
                        -> join('orders', 'productsPerOrder.idOrder', '=', 'orders.idOrder') 
                        -> get();

        //$products = DB::table('products')->paginate(15);
        $categories = Category::orderBy('name', 'asc')->get();
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cartItems = new Cart($oldCart);
        
        //$orders = Order::where('idUser', Auth::id()) -> get();


        if (Auth::check())
        {
            $orders = Order::where('idUser', Auth::id())
                    ->where('idOrder', request('orderId')) -> get();
            
            return view('order', ['products' => $products, 'categories' => $categories, 'cartItems' => $cartItems, 'orders' => $orders]);
            
        }

        else
            return view('/index', ['products' => $products, 'categories' => $categories, 'cartItems' => $cartItems,]);
    }
}
