<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class UserController extends Controller
{
    public function show()
    {
        return view('order');
    }
}
