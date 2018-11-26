<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Administrator;

class AdministrationUsersController extends Controller
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
        // $admins = User::orderBy('name', 'asc')->get();
        $admins = DB::table('users') 
                        ->join('administrators', 'users.idUser', '=', 'administrators.idAdministrator')
                        ->get();
        return view('administration.users.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administration.users.create');
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
            'password' => 'required|confirmed'
        ]);

        // Create and save the user

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password'))
        ]);

        // Insert into regular users
        
        Administrator::create([
            'idAdministrator' => $user['idUser']
        ]);

        // Redirect to the home page

        session()->flash('message', 'Account created');

        return redirect('administration/users');
    }
}
