<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Administrator;
use App\Category;
use App\Product;

class ProductTest extends DuskTestCase
{
    use DatabaseMigrations;
    
    public function testAdminCreateProduct_ValidProduct_NewProduct()
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
                    ->visit('/administration/products/create')
                    ->type('name', 'Sauce')
                    ->type('description', 'Spicy')
                    ->type('price', '2.99')
                    ->type('amount', '100')
                    ->attach('file', '/home/pares/Pictures/salsa.jpg')
                    ->check('active')
                    ->select('category', $category->name)
                    ->press('Submit')
                    ->assertSee('Sauce');
        });
    }

    public function testAdminEditProduct_ValidProduct_EditedProduct()
    {
        $password = 'toor';
        $user = User::create([
            'name' => 'root',
            'email' => 'root@localhost.com',
            'password' => bcrypt($password)
        ]);

        Administrator::create([
            'idAdministrator' => $user['idUser']
        ]);

        $category = Category::create([
            'name' => 'Food'
        ]);

        $product = Product::create([
            'name' => 'Sauce',
            'description' => 'Spicy',
            'price' => '2.99',
            'amount' => '100',
            'active' => '1',
            'image_path' => '1541002565.jpg'
        ]);

        $this->browse(function ($browser) use ($user, $category, $product) {
            $browser->loginAs($user->idUser)
                    ->visit('/administration/products')
                    ->press($product->name . '_edit')
                    ->type('name', 'Pancakes')
                    ->press('Submit')
                    ->assertSee('Pancakes');
        });
    }
    

    public function testAdminDisableProduct_ValidProduct_DisabledProduct()
    {
        $password = 'toor';
        $user = User::create([
            'name' => 'root',
            'email' => 'root@localhost.com',
            'password' => bcrypt($password)
        ]);

        Administrator::create([
            'idAdministrator' => $user['idUser']
        ]);

        $category = Category::create([
            'name' => 'Food'
        ]);

        $product = Product::create([
            'name' => 'Sauce',
            'description' => 'Spicy',
            'price' => '2.99',
            'amount' => '100',
            'active' => '1',
            'image_path' => '1541002565.jpg'
        ]);

        $this->browse(function ($browser) use ($user, $category, $product) {
            $browser->loginAs($user->idUser)
                    ->visit('/administration/products')
                    ->press($product->name . '_edit')
                    ->uncheck('active')
                    ->press('Submit')
                    ->assertSee('Sauce');
        });
    }
}
