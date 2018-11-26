<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{

	public function run()
	{
	    DB::table('users')->delete();
	    User::create(array(
	        'firstName'     => 'Chris',
	        'lastName'		=> 'Sevilleja',
	        'email'    => 'chris@scotch.io',
	        'password' => Hash::make('awesome'),
	        'created_at' 	=> NOW(),
	        'updated_at' 	=> NOW(),
	    ));
	}

}
