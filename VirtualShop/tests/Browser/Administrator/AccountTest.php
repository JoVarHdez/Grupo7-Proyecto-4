<?php

namespace Tests\Browser\Administrator;

use Tests\DuskTestCase;
use Laravel\Dusk\Chrome;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Administrator;

class AccountTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testAdminCreateUser_ValidUser_SuccessMessage()
    {
        if (\Auth::check()) auth()->logout();
        $password = 'toor';
        $user = User::create([
            'name' => 'root',
            'email' => 'root@localhost.com',
            'password' => bcrypt($password)
        ]);

        Administrator::create([
            'idAdministrator' => $user['idUser']
        ]);

        $this->browse(function ($browser) use ($user) {
            $browser->loginAs($user->idUser)
                    ->visit('/administration/users/create')
                    ->type('@input-name', 'bob')
                    ->type('email', 'bob@localhost.com')
                    ->type('password', 'toor')
                    ->type('password_confirmation', 'toor')
                    ->press('Submit')
                    ->assertSee('bob');
        });
    }



    public function testAdminCreateUser_EmailInUse_ErrorMessage()
    {
        if (\Auth::check()) auth()->logout();
        $password = 'toor';
        $user = User::create([
            'name' => 'root',
            'email' => 'root@localhost.com',
            'password' => bcrypt($password)
        ]);
        Administrator::create([
            'idAdministrator' => $user['idUser']
        ]);

        $this->browse(function ($browser) use ($user, $password) {
            $browser->loginAs($user->idUser)
                    ->visit('/administration/users/create')
                    ->type('name', $user->name)
                    ->type('email', $user->email)
                    ->type('password', $password)
                    ->type('password_confirmation', $password)
                    ->press('Submit')
                    ->assertSee('The email has already been taken');
        });
    }

}
