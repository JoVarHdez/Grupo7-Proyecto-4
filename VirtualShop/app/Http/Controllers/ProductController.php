<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\Cart;
use App\Comment;
use App\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;

class ProductController extends Controller
{
    public static function get_active_products()
    {
        return DB::table('products')
        ->where('active', 1)
        ->paginate(15);
    }

    public function index()
    {
        $products = ProductController::get_active_products();
        $categories = Category::orderBy('name', 'asc')->get();
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cartItems = new Cart($oldCart);

    	return view('index', ['products' => $products, 'categories' => $categories, 'cartItems' => $cartItems]);
    }

    public function search(Request $request)
    {
        $categories = Category::orderBy('name', 'asc')->get();

        $categorySearched = request('categorySearch');

        $oldCart = Session::get('cart');
        $cartItems = new Cart($oldCart);

        $sortRate = request("sortRate");
        if (is_null($sortRate))
            $sortRate = '5';

        $request -> session() -> put('sortRate', $sortRate);
        
        if ($categorySearched != "")
        {
            $currentCategory = Category::find((int)$categorySearched);
            $search = "";
            if (request("search") != '')
                $search = request("search");
                
            $products = DB::select(
                'call select_active_products_with_rate_by_category(?, ?, ?, ?)',
                [
                    $currentCategory->idCategory,
                    $search,
                    $search,
                    $sortRate,
                ]
            );

            $request -> session() -> put('categorySearched', $currentCategory -> name);
        }
        

        else
        {
            $search = "";
            if (request("search") != '')
                $search = request("search");



            $request -> session() -> put('categorySearched', 'All Categories');
            $products = DB::select(
                'call select_active_products_with_rate(?, ?, ?)',
                [
                    $search,
                    $search,
                    $sortRate,
                ]
            );

        }
        
        $request -> session() -> put('searched', request('search'));                  
        return view('product', ['products' => $products, 'categories' => $categories, 'cartItems' => $cartItems]);
    }

    public function showProducts()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $products = ProductController::get_active_products();

        $oldCart = Session::get('cart');
        $cartItems = new Cart($oldCart);


        return view('product', ['products' => $products, 'categories' => $categories, 'cartItems' => $cartItems]);
    }

    public function showProductDetail(Request $request, $id)
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $product = Product::find($id);

        $oldCart = Session::get('cart');
        $cartItems = new Cart($oldCart);

        $comments = Comment::latest('created_at')
                    -> select('comments.idUser', 'comments.created_at', 'comments.idComment', 'comments.content', 'users.name')
                    -> join('users', 'users.idUser', '=', 'comments.idUser')
                    -> where("idProduct", $id) 
                    -> get();

        if (Auth::check())
        {
            $userRate = Rate::where("idProduct", $id)
                            -> where("idUser", Auth::id())
                            -> first();

            if (is_null($userRate))
            {
                $userRate = new Rate();
                $userRate -> rate = -1; 
            }

        }           
        else
        {
            $userRate = new Rate();
            $userRate -> rate = -1;
        }

       
        $ratesSum = Rate::where("idProduct", $id)
                            -> sum("rate");

        $ratesCount = Rate::where("idProduct", $id)
                            -> count();
       
        if ($ratesCount > 0)
            $globalRate = $ratesSum / $ratesCount;
        else
            $globalRate = 0;

        if (is_null($ratesSum))
            $ratesSum = 0;

        $globalRateData = array(
            "globalRate" => $globalRate,
            "ratesQuantity" => $ratesCount,
            "ratesSum" => $ratesSum
        );


        return view('single', ['product' => $product, 
                               'categories' => $categories, 
                               'cartItems' => $cartItems,
                               'comments' => $comments,
                               'userRate' => $userRate,
                               'globalRateData' => $globalRateData
                               ]);
    }

    public function getAddToCart(Request $request, $id)
    {
        $product = Product::find($id);
        if (Session::has('cart'))
            $oldCart = Session::get('cart');
        else
            $oldCart = null;

        if ($product -> amount > 0)
        {
            $cart = new Cart($oldCart);
            $cart -> add($product, $product -> idProduct);

            if (Auth::check())
            {
                $cartId = Cart::where('idUser', Auth::id()) -> first();
                $idCart = $cartId['idCart'];
                
                $dataBaseProducts = Cart::find($idCart) -> products() -> get();
                
                if (!is_null($cart -> items))
                {
                    foreach($cart -> items as $item)
                    {
                        if (Cart::json_key_exists($item['item'] -> idProduct, $dataBaseProducts) == -1)
                        {
                            Cart::find($idCart) -> products()->attach($item['item'] -> idProduct, ["productQuantity" => $item['quantity']]);
                        }
                        else
                        {
                            Cart::find($idCart) -> products()->updateExistingPivot($item['item'] -> idProduct, ["productQuantity" => $item['quantity']]);
                        }
                    }
                }
            }
        
            $request -> session() -> put('cart', $cart);
            return redirect() -> back();
        }
        else
        {
            return back()->withErrors([
                'message' => $product -> name.' is out of stock'
            ]);
        }
    }
}
