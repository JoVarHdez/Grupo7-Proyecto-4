<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class AdministrationCategoryController extends Controller
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
        $categories = Category::orderBy('name', 'asc')->get();
        return view('administration.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administration.categories.create');
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
            'name' => 'required|unique:categories,name'
        ]);

        $category = Category::create([
            'name' => request('name')
        ]);

        // Redirect to the home page

        session()->flash('message', 'Category created');

        return redirect('administration/categories');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('administration/categories/edit', compact('category'));
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
            'name' => 'required|unique:categories,name'
        ]);

        try{
            $category = Category::findOrFail($id);

            $category->name = $request['name'];

            $category->save();

            session()->flash('message', 'Category updated');
            return redirect('administration/categories');
        }
        catch(ModelNotFoundException $err){
            //Show error page
        }
    }
}
