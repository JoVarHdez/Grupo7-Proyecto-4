<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\RegularUser;
use App\Cart;

class RegistrationController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('register.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the form

        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed',
            'terms_and_conditions' => 'required'
        ]);

        // Create and save the user

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password'))
        ]);

        // Insert into regular users
        
        RegularUser::create([
            'idRegularUser' => $user['idUser']
        ]);

        DB::table('carts')->insert(
            ['idUser' => $user['idUser']]
        );

        // Sign them in

        auth()->login($user);

        // Redirect to the home page

        session()->flash('message', 'Registered');

        return redirect()->home();
    }
}
