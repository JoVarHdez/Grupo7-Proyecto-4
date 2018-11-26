<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use Illuminate\Support\Facades\Storage;

class AdministrationProductController extends Controller
{
    public function __construct()
    {
        
        // only administrators are allowed to view this
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('name', 'asc')->get();
        return view('administration.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return view('administration.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'amount' => 'required|integer|min:0',
            'file' => 'image|max:2048|required',
            'category' => 'required',
        ]);

        $category = Category::where('name', 'LIKE', request('category'))->get();

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $filename =time().'.'.$extension;
        $file->move('products/', $filename);

        $product = Product::create([
            'name' => request('name'),
            'description' => request('description'),
            'price' => request('price'),
            'amount' => request('amount'),
            'image_path' => $filename,
            'active' => 1,
        ]);

        Product::find($product->idProduct)->categories()->attach($category[0]['idCategory']);

        session()->flash('message', 'Product created');

        return redirect('administration/products');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name', 'asc')->get();

        $currentCategories = Product::find($product->idProduct)->categories()->get();
        $cat = [];
        foreach ($currentCategories as $curr)
        {
            $cat[] = $curr->name;
        }
        
        return view('administration/products/edit', compact('product','categories', 'cat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'amount' => 'required|integer|min:0',
            'file' => 'image|max:2048',
        ]);

        try{
            $product= Product::findOrFail($id);

            $product->name = $request['name'];
            $product->description = $request['description'];
            $product->price = $request['price'];
            $product->amount = $request['amount'];

            if ($request->hasFile('file') ? true : false)
            {
                // Deleting not working
                if ($product->image_path != "")
                {
                    $path = public_path() . '/products/' . $product->image_path;
                    if(file_exists($path)) {
                        unlink($path);
                    }
                }
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                $filename =time().'.'.$extension;
                $file->move('products/', $filename);

                $product->image_path = $filename;
            }

            $product->active = ($request['active'] ? true : false);

            $product->save();

            session()->flash('message', 'Product updated');
            return redirect('administration/products');
        }
        catch(ModelNotFoundException $err){
            //Show error page
        }
    }
}
