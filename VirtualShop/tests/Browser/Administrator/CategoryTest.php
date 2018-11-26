<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Administrator;
use App\Category;

class CategoryTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/index')
                    ->assertPathIs('/index');
        });
    }
    
    public function testAdminCreateCategory_ValidCategory_NewCategory()
    {

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
            $browser->loginAs($user->idUser)
                    ->visit('/administration/categories/create')
                    ->type('name', 'Clothing')
                    ->press('Submit')
                    ->assertSee('Clothing');
        });
    }

    public function testAdminCreateCategory_ExistingCategory_ErrorMessage()
    {

        $password = 'toor';
        $user = User::create([
            'name' => 'root1',
            'email' => 'root1@localhost.com',
            'password' => bcrypt($password)
        ]);

        Administrator::create([
            'idAdministrator' => $user['idUser']
        ]);

        $category = Category::create([
            'name' => 'Food'
        ]);

        $this->browse(function ($browser) use ($user, $category) {
            $browser->loginAs($user->idUser)
                    ->visit('/administration/categories/create')
                    ->type('name', $category->name)
                    ->press('Submit')
                    ->assertSee('The name has already been taken');
        });
    }

    public function testAdminEditCategory_ValidCategory_EditedCategory()
    {
        $password = 'toor';
        $user = User::create([
            'name' => 'root',
            'email' => 'root@localhost.com',
            'password' => bcrypt($password)
        ]);

        $administrator = Administrator::create([
            'idAdministrator' => $user['idUser']
        ]);

        $category = Category::create([
            'name' => 'Clothing'
        ]);

        $this->browse(function ($browser) use ($user, $category) {
            $browser->loginAs($user->idUser)
                    ->visit('/administration/categories')
                    ->press($category->name . '_edit')
                    ->type('name', 'Electronics')
                    ->press('Submit')
                    ->assertSee('Electronics');
        });
    }
    

}
