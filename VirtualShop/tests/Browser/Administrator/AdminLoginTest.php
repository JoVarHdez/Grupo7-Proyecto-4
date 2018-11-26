<?php
namespace Tests\Browser;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use App\User;
use App\Administrator;
class AdminLoginTest extends DuskTestCase
{
    use DatabaseMigrations;
    
    public function testIsValidAdminLogIn_InCorrectPassword_ReturnsErrorMessage()
    {
        if (\Auth::check()) auth()->logout();
        $password = 'toor';
        $user = User::create([
            'name' => 'root1',
            'email' => 'root1@localhost.com',
            'password' => bcrypt($password)
        ]);

        Administrator::create([
            'idAdministrator' => $user['idUser']
        ]);
        
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/administration/login')
                    ->type('email', $user->email)
                    ->type('password', 'test')
                    ->press('Sign in')
                    ->assertSee('Please check your credentials and try again.');
        });
    }
    public function testIsValidAdminLogIn_NoCredentials_ReturnsErrorMessage()
    {
        if (\Auth::check()) auth()->logout();
        $this->browse(function (Browser $browser) {
            $browser->visit('/administration/login')
                    ->press('Sign in')
                    ->assertPathIs('/administration/login');
        });
    }
    public function testIsValidAdminLogIn_CorrectCredentials_ReturnsLoggedInView()
    {
        if (\Auth::check()) auth()->logout();
        $userTest = factory('App\User')->make();
        $password = 'toor';
        $user = User::create([
            'name' => 'root1',
            'email' => 'root1@localhost.com',
            'password' => bcrypt($password)
        ]);

        Administrator::create([
            'idAdministrator' => $user['idUser']
        ]);

        $this->browse(function ($browser) use ($user, $password) {
            $browser->visit('/administration/login')
                    ->type('email', $user->email)
                    ->type('password', $password)
                    ->press('Sign in')
                    ->assertSee($user->name);
        });
    }

    public function testIsUserLogIn_InCorrectView_ReturnsUserView()
    {
        $password = '123456';
        $user = User::create([
            'name' => 'user',
            'email' => 'user@localhost.com',
            'password' => bcrypt($password)
        ]);
        $this->browse(function ($browser) use ($user, $password) {
            $browser->visit('/administration/login')
                    ->type('email', $user->email)
                    ->type('password', $password)
                    ->press('Sign in')
                    ->assertPathIs('/');
        });
    }
}