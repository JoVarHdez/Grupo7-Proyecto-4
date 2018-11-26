<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Chrome;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Product;
use App\RegularUser;
use App\User;
use App\Category;
use Illuminate\Support\Facades\DB;

class ShoppingCartTest extends DuskTestCase
{
    use DatabaseMigrations;

   
    /**
     * @group addProduct
     */
    public function testAddProductToCart_LogUser_ReturnsCartInView()
    {
        if (\Auth::check()) auth()->logout();
        $password = 'toor';
        $user = User::create([
            'name' => 'root1',
            'email' => 'root1@localhost.com',
            'password' => bcrypt($password)
        ]);
        
        DB::table('carts')->insert(
            ['idUser' => $user['idUser']]
        );

        $category = Category::create([
            'name' => 'Hoodie naruto'
        ]);

        $product = Product::create([
            'name' => 'Hoodie naruto jonin',
            'description' => 'Hoodie naruto jonin ',
            'price' => 10000,
            'amount' => 100,
            'image_path' => '1540180484.jpg',
            'active' => 1,
        ]);
        Product::find($product->idProduct)->categories()->attach($category->idCategory);

        $url = 'http://localhost:8000/product-detail/'.strval($product->idProduct).'';
        
         $this->browse(function ($browser, $table) use ($user,$product,$url){
             $browser->loginAs($user->idUser)
                     ->visit($url)
                     ->press('Add to cart')
                     ->visit('/checkout?')
                     ->assertSee($product->name);
         });
    }

    /**
     * @group addProduct1
     */
    public function testAddProductToCart_ProductAlreadyExist_ReturnAdd1tocartInView()
    {
        if (\Auth::check()) auth()->logout();
        $password = 'toor';
        $user = User::create([
            'name' => 'root1',
            'email' => 'root1@localhost.com',
            'password' => bcrypt($password)
        ]);
        
        DB::table('carts')->insert(
            ['idUser' => $user['idUser']]
        );
        
        $category = Category::create([
            'name' => 'Hoodie naruto'
        ]);

        $product = Product::create([
            'name' => 'Hoodie naruto jonin',
            'description' => 'Hoodie naruto jonin ',
            'price' => 10000,
            'amount' => 100,
            'image_path' => '1540180400.jpg',
            'active' => 1,
        ]);

        Product::find($product->idProduct)->categories()->attach($category->idCategory);

        $url = 'http://localhost:8000/product-detail/'.strval($product->idProduct).'';
        //run with migration
         $this->browse(function ($browser , $table) use ($user, $product, $url){
             $browser->loginAs($user->id)
                     ->visit($url)
                     ->assertUrlIs($url)
                     ->assertSee('Product Detail')
                     ->press('Add to cart')
                     ->visit($url)
                     ->press('Add to cart')
                     ->visit($url)
                     ->press('Add to cart')
                     ->visit('/checkout?')
                     ->assertSee('3');
 
         });

    }


    /**
     * @group addProduct2
     */
    public function testAddProductToCart_UnlogedUser_ReturnsAddproductView()
    {
        if (\Auth::check()) auth()->logout();
               
        $category = Category::create([
            'name' => 'Hoodie naruto'
        ]);

        $product = Product::create([
            'name' => 'Hoodie naruto jonin',
            'description' => 'Hoodie naruto jonin ',
            'price' => 10000,
            'amount' => 100,
            'image_path' => '1540180400.jpg',
            'active' => 1,
        ]);
        Product::find($product->idProduct)->categories()->attach($category->idCategory);

        $url = 'http://localhost:8000/product-detail/'.strval($product->idProduct).'';

        //run with migration
         $this->browse(function ($browser) use($product,$url){
            $browser->visit($url)
                    ->assertSee('Product Detail')
                     ->press('Add to cart')
                    ->visit('http://localhost:8000/checkout?')
                    ->assertSee($product->name);
                });
         }

    /**
     * @group removeProduct
     */
    public function testRemoveProductCart_UnlogedUser_ReturnsCartInView()
    {
        if (\Auth::check()) auth()->logout();
               
        $category = Category::create([
            'name' => 'Hoodie naruto'
        ]);

        $product = Product::create([
            'name' => 'Hoodie naruto jonin',
            'description' => 'Hoodie naruto jonin ',
            'price' => 10000,
            'amount' => 100,
            'image_path' => '1540180400.jpg',
            'active' => 1,
        ]);
        Product::find($product->idProduct)->categories()->attach($category->idCategory);

        $url = '/product-detail/'.strval($product->idProduct).'';

        //run with migration
         $this->browse(function ($browser,$table) use ($product, $url){
            $browser->visit($url)
                    ->assertSee('Product Detail')
                    ->press('Add to cart')
                    ->visit('/checkout?')
                    ->assertSee($product->name)
                    ->clickLink(' ')
                    ->assertDontSee($product->name);

        });

        
    }

    /**
     * @group removeProduct1
     */
    public function testRemoveProductCart_LogedUser_ReturnsCartInView()
    {
        if (\Auth::check()) auth()->logout();
        $password = 'toor';
        $user = User::create([
            'name' => 'root1',
            'email' => 'root1@localhost.com',
            'password' => bcrypt($password)
        ]);
        
        DB::table('carts')->insert(
            ['idUser' => $user['idUser']]
        );

        $category = Category::create([
            'name' => 'Hoodie naruto'
        ]);

        $product = Product::create([
            'name' => 'Hoodie naruto jonin',
            'description' => 'Hoodie naruto jonin ',
            'price' => 10000,
            'amount' => 100,
            'image_path' => '1540180400.jpg',
            'active' => 1,
        ]);
        Product::find($product->idProduct)->categories()->attach($category->idCategory);

        $url = '/product-detail/'.strval($product->idProduct).'';

        //run with migration
         $this->browse(function ($browser,$table) use ($user,$product,$url){
            $browser->loginAs($user->id)
                    ->visit($url)
                    ->assertSee('Product Detail')
                    ->press('Add to cart')
                    ->visit('/checkout?')
                    ->assertSee($product->name)
                    ->clickLink(' ')
                    ->assertDontSee($product->name);
        });

       
    }


   

    /**
     * @group seeProductCart
     */
    public function testSeeProductCart_UnlogedUser_ReturnsCartInView()
    {
        if (\Auth::check()) auth()->logout();
               
        $category = Category::create([
            'name' => 'Hoodie naruto'
        ]);

        $product = Product::create([
            'name' => 'Hoodie naruto jonin',
            'description' => 'Hoodie naruto jonin ',
            'price' => 10000,
            'amount' => 100,
            'image_path' => '1540180400.jpg',
            'active' => 1,
        ]);
        Product::find($product->idProduct)->categories()->attach($category->idCategory);

        $url = '/product-detail/'.strval($product->idProduct).'';

        //run with migration
         $this->browse(function ($browser,$table) use ($product,$url){
            $browser->visit($url)
                    ->assertSee('Product Detail')
                    ->press('Add to cart')
                    ->visit('/checkout?')
                    ->assertSee($product->name);

        });
    }

    /**
     * @group seeProductCart1
     */
    public function testSeeProductCart_SeeCart_ReturnsCorrectProductsInView()
    {
        if (\Auth::check()) auth()->logout();
        $password = 'toor';
        $user = User::create([
            'name' => 'root1',
            'email' => 'root1@localhost.com',
            'password' => bcrypt($password)
        ]);
        
        DB::table('carts')->insert(
            ['idUser' => $user['idUser']]
        );

        $category = Category::create([
            'name' => 'Hoodie naruto'
        ]);

        $product = Product::create([
            'name' => 'Hoodie naruto jonin',
            'description' => 'Hoodie naruto jonin ',
            'price' => 10000,
            'amount' => 100,
            'image_path' => '1540180400.jpg',
            'active' => 1,
        ]);
        Product::find($product->idProduct)->categories()->attach($category->idCategory);

        $url = '/product-detail/'.strval($product->idProduct).'';

        //run with migration
         $this->browse(function ($browser,$table) use ($user,$product,$url){
            $browser->loginAs($user->id)
                    ->visit($url)
                    ->assertSee('Product Detail')
                    ->press('Add to cart')
                    ->visit('/checkout?')
                    ->assertSee($product->name);

        });

    }

    /**
     * @group seeProductCart2
     */
    public function testSeeProductCart_SeeCart_ReturnsCorrectAmountInView()
    {
        if (\Auth::check()) auth()->logout();
        $password = 'toor';
        $user = User::create([
            'name' => 'root1',
            'email' => 'root1@localhost.com',
            'password' => bcrypt($password)
        ]);
        
        DB::table('carts')->insert(
            ['idUser' => $user['idUser']]
        );
        
        $category = Category::create([
            'name' => 'Hoodie naruto'
        ]);

        $product = Product::create([
            'name' => 'Hoodie naruto jonin',
            'description' => 'Hoodie naruto jonin ',
            'price' => 10000,
            'amount' => 100,
            'image_path' => '1540180400.jpg',
            'active' => 1,
        ]);
        Product::find($product->idProduct)->categories()->attach($category->idCategory);

        $url = '/product-detail/'.strval($product->idProduct).'';

         $this->browse(function ($browser , $table) use($user,$product,$url){
             $browser->loginAs($user->id)
                     ->visit($url)
                     ->assertSee('Product Detail')
                     ->press('Add to cart')
                     ->visit('/checkout?')
                     ->assertSee('1');
         });

    }

    /**
     * @group seeProductCart3
     */
    public function testSeeProductCart_SeeCart_ReturnsCorrectInfoInView()
    {
        if (\Auth::check()) auth()->logout();
        $password = 'toor';
        $user = User::create([
            'name' => 'root1',
            'email' => 'root1@localhost.com',
            'password' => bcrypt($password)
        ]);
        
        DB::table('carts')->insert(
            ['idUser' => $user['idUser']]
        );

        $category = Category::create([
            'name' => 'Hoodie naruto'
        ]);

        $product = Product::create([
            'name' => 'Hoodie naruto jonin',
            'description' => 'Hoodie naruto jonin ',
            'price' => 10000,
            'amount' => 100,
            'image_path' => '1540180400.jpg',
            'active' => 1,
        ]);
        Product::find($product->idProduct)->categories()->attach($category->idCategory);

        $url = '/product-detail/'.strval($product->idProduct).'';

        //run with migration
         $this->browse(function ($browser,$table) use ($user,$product,$url){
            $browser->loginAs($user->id)
                    ->visit($url)
                    ->assertSee('Product Detail')
                    ->press('Add to cart')
                    ->visit('/checkout?')
                    ->assertSee($product->name)
                              ->assertSee($product->price)
                              ->assertSee($product->idProduct)
                              ->assertSee('1'); //amount

        });

    }

    /**
     * @group seeProductCart4
     */
    public function testSeeProductCart_SeeCart_ReturnsCorrectTotalCostInView()
    {
        if (\Auth::check()) auth()->logout();
               
        $category1 = Category::create([
            'name' => 'Hoodie naruto'
        ]);

        $category2 = Category::create([
            'name' => 'Hoodie One Punch'
        ]);

        $product1 = Product::create([
            'name' => 'Hoodie naruto jonin',
            'description' => 'Hoodie naruto jonin ',
            'price' => 10000,
            'amount' => 100,
            'image_path' => '1540180400.jpg',
            'active' => 1,
        ]);

        $product2 = Product::create([
            'name' => 'Hoodie One Punch Man white',
            'description' => 'Hoodie One Punch Man white',
            'price' => 11000,
            'amount' => 100,
            'image_path' => '1540180603.jpg',
            'active' => 1,
        ]);
        Product::find($product1->idProduct)->categories()->attach($category1->idCategory);
        Product::find($product2->idProduct)->categories()->attach($category2->idCategory);

        $url1 = '/product-detail/'.strval($product1->idProduct).'';
        $url2 = '/product-detail/'.strval($product2->idProduct).'';
        $total = 'Total = $'.strval(($product1->price)+($product2->price));

        //run with migration
         $this->browse(function ($browser) use($product1,$product2,$url1,$url2,$total){
            $browser->visit($url1)
                    ->assertSee('Product Detail')
                    ->press('Add to cart')
                    ->visit($url2)
                    ->press('Add to cart')
                    ->visit('/checkout?')
                    ->assertSee($total);
                });
       
    }

    /**
     * @group completeOrder
     */
    public function testCompleteOrder_ValidOrder_ReturnsOrdersInView()
    {
        if (\Auth::check()) auth()->logout();
        $password = 'toor';
        $user = User::create([
            'name' => 'root1',
            'email' => 'root1@localhost.com',
            'password' => bcrypt($password)
        ]);
        
        DB::table('carts')->insert(
            ['idUser' => $user['idUser']]
        );
        
        $category = Category::create([
            'name' => 'Hoodie naruto'
        ]);

        $product = Product::create([
            'name' => 'Hoodie naruto jonin',
            'description' => 'Hoodie naruto jonin ',
            'price' => 10000.0,
            'amount' => 100,
            'image_path' => '1540180400.jpg',
            'active' => 1,
        ]);
        Product::find($product->idProduct)->categories()->attach($category->idCategory);

        $url = '/product-detail/'.strval($product->idProduct).'';
        $orderLink = strval($user->name.'\'s orders');
        $price = '$'.strval($product->price);
        //run with migration  fallo al probar
         $this->browse(function ($browser) use($user,$product,$orderLink , $url, $price){
             $browser->loginAs($user->idUser)
                     ->visit($url)
                     ->press('Add to cart')
                     ->pause(1000)
                     ->visit('/checkout')
                     ->assertSee($product->name)
                     ->clickLink('Make Payment')
                     ->clickLink($orderLink)
                     ->assertSee($product->name)
                     ->assertSee($price);
 
         });

         /* $orders = strval("Admi1's orders");
        //run with transaction
         $this->browse(function ($browser) use ($orders){
            $browser->loginAs(3)
                    ->visit('/product-detail/5')
                    ->assertSee('Product Detail')
                    ->press('@add_botton')
                    ->visit('/checkout?')
                    ->assertSee('Hoodie naruto jonin')
                    ->clickLink('Make Payment')
                    ->clickLink($orders)
                    ->assertSee('Hoodie naruto jonin')
                    ->assertSee('$'.strval(10000));

        }); */
    }


    /**
     * @group completeOrder1
     */
    public function testCompleteOrder_WithoutProducts_CantMakeCheckout()
    {
        if (\Auth::check()) auth()->logout();
        $password = 'toor';
        $user = User::create([
            'name' => 'root1',
            'email' => 'root1@localhost.com',
            'password' => bcrypt($password)
        ]);
        
        DB::table('carts')->insert(
            ['idUser' => $user['idUser']]
        );
       
      
        //run with migration
         $this->browse(function ($browser) use($user){
             $browser->loginAs($user->id)
                     ->visit('/index')
                     ->assertSee('items: 0')
                     ->press('@cart_botton')
                     ->pause(1000)
                     ->assertSee('Cart is empty.'); 
         });

        
    }

    /**
     * @group completeOrder2
     */
    public function testCompleteOrder_WithProductsNotAvailable_ReturnsCantAddToCart()
    {
        $category = Category::create([
            'name' => 'Hoodie naruto'
        ]);

        $product = Product::create([
            'name' => 'Hoodie One Punch Man white',
            'description' => 'Hoodie One Punch Man',
            'price' => 1000,
            'amount' => 10,
            'image_path' => '1540180603.jpg',
            'active' => 0,
        ]);
        Product::find($product->idProduct)->categories()->attach($category->idCategory);
        
        
        //Run with migration
            $this->browse(function ($browser) use ($product) {
            $browser->visit('/index')
                    ->type('search', $product->name)
                    ->press('Search')
                    ->assertPathIs('/product')
                    ->assertDontSee($product->name);

        });
    }
}
