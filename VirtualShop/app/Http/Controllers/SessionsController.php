<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;
use App\Cart;

class SessionsController extends Controller
{

    public function __construct()
    {
        // only guests are allowed to view this
        $this->middleware('guest', ['except' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sessions.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function mergeCart(Request $request)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);

        $cartId = Cart::where('idUser', Auth::id()) -> first();

        if (is_null($cartId))
        {
            $cart -> idUser = Auth::id();
            $newCart = new Cart($cart);
            $newCart -> save();

            $cartId = Cart::where('idUser', Auth::id()) -> first();
            $cart -> primaryKey = $cartId;
        }
    
        $idCart = $cartId['idCart'];

        $dataBaseProducts = Cart::find($idCart) -> products() 
                            -> select("productsPerCart.productQuantity", 
                                        "productsPerCart.idProduct", 
                                        "products.name", 
                                        "products.amount",
                                        "products.price",
                                        "products.image_path",
                                        "products.description",
                                        "products.active") 
                            -> get();
        //dd($dataBaseProducts -> toArray());


        if (!is_null($dataBaseProducts))
        {
            foreach($dataBaseProducts as $product)
            {
                $dbProductIndex = Cart::json_key_exists($product  -> idProduct, $dataBaseProducts);
                $dbQuantity = $dataBaseProducts[$dbProductIndex]['productQuantity'];
                if (!is_null($cart -> items))
                {
                    
                    if (array_key_exists($product -> idProduct, $cart -> items))
                    {
                        $cart -> items[$product -> idProduct]['quantity'] += $dbQuantity;
                    }    
                    else  
                    {
                        $cart -> insert($product, $product -> idProduct, $dbQuantity, $product->price);
                    }
                }
                else
                {
                    $cart -> insert($product, $product -> idProduct, $dbQuantity, $product->price);
                }
                
            }
            $request -> session() -> put('cart', $cart);

            if (!is_null($cart -> items))
            {
                foreach($cart -> items as $item)
                {
                    $productIndex = Cart::json_key_exists($item['item'] -> idProduct, $dataBaseProducts);
                    if  ($productIndex == -1)
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
        else
        {
            if (!is_null($cart -> items))
            {
                foreach($cart -> items as $item)Cart::find($idCart) -> products()->updateExistingPivot($item['item'] -> idProduct, ["productQuantity" => $item['quantity']]);
                {
                    Cart::find($idCart) -> products()->attach($item['item'] -> idProduct, ["productQuantity" => $item['quantity']]);
                }
            }
        }

        
    }

    
    public function store(Request $request)
    {
        $this->validate(request(), [
            'email' => 'required|email',
            'password' => 'required'

        ]);

        // Attempt to auth user

        if (! auth()->attempt(request(['email', 'password'])))
        {
            return back()->withErrors([
                'message' => 'Please check your credentials and try again.'
            ]);
        }


        session()->flash('message', 'Succesfully Logged in!');
        $this -> mergeCart($request);

        return redirect()->home(); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        auth()->logout();
        Session::forget('cart');
        return redirect()->home();
    }
}
