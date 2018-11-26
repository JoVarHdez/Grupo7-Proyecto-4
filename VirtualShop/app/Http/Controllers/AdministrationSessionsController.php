<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdministrationSessionsController extends Controller
{

    public function __construct()
    {
        // only guests are allowed to view this
        $this->middleware('guest', ['except' => 'destroy']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administration.login');
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
        return redirect()->route('admin_home');
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
        return redirect()->route('admin_login');
    }
}
