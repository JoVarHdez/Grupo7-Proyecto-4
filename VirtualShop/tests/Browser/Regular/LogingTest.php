<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class LogingTest extends DuskTestCase
{
    use DatabaseMigrations;
     
    public function testIsValidLogIn_InCorrectPassword_ReturnsErrorMessage()
    {
        $password = '123456';
        $user = User::create([
            'name' => 'user',
            'email' => 'user@localhost.com',
            'password' => bcrypt($password)
        ]);

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/index')
                    ->clickLink(' Log In ')
                    ->pause(1000)
                    ->type('@login-email-input', $user->email)
                    ->type('@login-password-input', 'test')
                    ->press('Log in')
                    ->assertSee('Please check your credentials and try again');
        });
    }


    public function testIsValidLogIn_CorrectCredentials_ReturnsLoggedInView()
    {

        $password = '123456';
        $user = User::create([
            'name' => 'user',
            'email' => 'user@localhost.com',
            'password' => bcrypt($password)
        ]);

        $this->browse(function ($browser) use ($user, $password) {
            $browser->visit('/index')
                    ->clickLink(' Log In ')
                    ->pause(1000)
                    ->type('@login-email-input', $user->email)
                    ->type('@login-password-input', $password)
                    ->press('Log in')
                    ->assertSee($user->name);
        });

        $this->assertDatabaseHas('users', [
            'idUser' => $user->idUser,
        ]);
    }
    

}
