<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
    	return view('index');
    }
}
