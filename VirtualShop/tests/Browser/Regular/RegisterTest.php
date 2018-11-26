<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class RegisterTest extends DuskTestCase
{
    use DatabaseMigrations;
     
    public function testCreateUser_ValidUser_SuccessMessage()
    {
        $this->browse(function ($browser){
            $browser->visit('/index')
                    ->clickLink(' Register ')
                    ->pause(1000)
                    ->type('@register-name-input', 'Alice')
                    ->type('@register-email-input', 'alice@example.com')
                    ->type('@register-password-input', '1234567')
                    ->type('@register-password_confirmation-input', '1234567')
                    ->check('@agree')
                    ->press('Register')
                    ->assertSee('Welcome alice@example.com')
                    ->assertAuthenticated();
        });

        $this->assertDatabaseHas('users', [
            'email' => 'alice@example.com',
        ]);
    }

    public function testAdminCreateUser_EmailInUse_ErrorMessage()
    {
        $password = '1234567';
        $user = User::create([
            'name' => 'Alice',
            'email' => 'alice@example.com',
            'password' => bcrypt($password)
        ]);

        $this->browse(function ($browser) use ($user, $password) {
            $browser->visit('/index')
                    ->clickLink(' Register ')
                    ->pause(1000)
                    ->type('@register-name-input', $user->name)
                    ->type('@register-email-input', $user->email)
                    ->type('@register-password-input', $password)
                    ->type('@register-password_confirmation-input', $password)
                    ->check('@agree')
                    ->press('Register')
                    ->assertSee('The email has already been taken.');
        });
    }
    
}
