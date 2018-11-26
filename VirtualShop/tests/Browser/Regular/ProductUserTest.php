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

class ProductUserTest extends DuskTestCase
{
    use DatabaseMigrations;

 
     /**
     * @group selectProduct
     */
     public function testSelectProduct_ProductExist_ReturnInfoProductInView()
     {
         $category = Category::create([
            'name' => 'Hoodie naruto'
        ]);

        $product = Product::create([
            'name' => 'Hoodie naruto jonin',
            'description' => 'Hoodie naruto jonin ',
            'price' => 10000,
            'amount' => 100,
            'image_path' => '1541002565.jpg',
            'active' => 1,
        ]);

        Product::find($product->idProduct)->categories()->attach($category->idCategory);
        $url = '/product-detail/'.strval($product->idProduct).'';

        $this->browse(function ($browser) use ($url,$product) {
            $browser->visit('/index')
                    ->clickLink($product->name)
                    ->assertPathIs($url)
                    ->assertSee($product->name);
        });
     }
 
    

     /**
     * @group search
     */
     public function testSearchProduct_ProductExist_ReturnProductInView()
     {
                
        $category = Category::create([
            'name' => 'Hoodie naruto'
        ]);

        $product = Product::create([
            'name' => 'Hoodie naruto jonin',
            'description' => 'Hoodie naruto jonin ',
            'price' => 10000,
            'amount' => 100,
            'image_path' => '1541002565.jpg',
            'active' => 1,
        ]);
        Product::find($product->idProduct)->categories()->attach($category->idCategory);

         $this->browse(function ($browser) use($product){
             $browser
                     ->visit('/index')
                     ->assertPathIs('/index')
                     ->type('search', $product->name)
                     ->press('Search')
                     ->assertPathIs('/product')
                     ->assertSee($product->name); 
 
         });
     }
     
     /**
     * @group search
     */
     public function testSearchProduct_ProductDonotExist_ReturnNoFoundInView()
     {
        $this->browse(function ($browser){
            $browser
                    ->visit('/index')
                    ->assertPathIs('/index')
                    ->type('search', 'Dragon ball')
                    ->press('Search')
                    ->assertPathIs('/product')
                    ->assertDontSee('Dragon ball');

        });
     }
 

     /**
     * @group search
     */
     public function testSearchProduct_InactiveProduct_ReturnNoFoundInView()
     {
        
        $category = Category::create([
            'name' => 'Hoodie One Punch Man'
        ]);

        $product = Product::create([
            'name' => 'Hoodie One Punch Man white',
            'description' => 'Hoodie One Punch Man',
            'price' => 1000,
            'amount' => 10,
            'image_path' => '1541002565.jpg',
            'active' => 0,
        ]);
        Product::find($product->idProduct)->categories()->attach($category->idCategory);
        
            $this->browse(function ($browser) use ($product) {
            $browser->visit('/index')
                    ->type('search', $product->name)
                    ->press('Search')
                    ->assertPathIs('/product')
                    ->assertDontSee($product->name);

        });
     }

     /**
     * @group search
     */
     public function testSearchProduct_WithoutInfo_ReturnAllProductsInView()
     {
        $this->browse(function ($browser) {
            $browser->visit('/index')
                    ->type('search', '')
                    ->press('Search')
                    ->assertPathIs('/product')
                    ->assertSee('All Categories');

        });
     }
 
    
    /**
     * @group selectCategory
     */
     public function testSelectCategory_ValidCategory_ReturnProductsInView()
     {
        $category = Category::create([
            'name' => 'Hoodie one punch man'
        ]);

        $product = Product::create([
            'name' => 'Hoodie One Punch Man white',
            'description' => 'Hoodie One Punch Man',
            'price' => 1000,
            'amount' => 10,
            'image_path' => '1541002565.jpg',
            'active' => 1,
        ]);
        Product::find($product->idProduct)->categories()->attach($category->idCategory);

        $this->browse(function ($browser) use ($category,$product) {
            $browser->visit('/index')
                    ->select('categorySearch', $category['idCategory'])
                    ->press('Search')
                    ->assertPathIs('/product')
                    ->assertSee($category->name);

        });


     }
     
     /**
     * @group selectCategory1
     */
     public function testSelectCategory_UnselectedCategory_ReturnAllCategoriesInView()
     {
        $this->browse(function ($browser) {
            $browser->visit('/index')
                    ->select('categorySearch', '')
                    ->press('Search')
                    ->assertPathIs('/product')
                    ->assertSee('All Categories');

        });
     }
 
     
     /**
     * @group comment
     */
     public function testCommentProduct_CommentBlank_ReturnErrorMessageInView()
     {
         
        if (\Auth::check()) auth()->logout();
        $password = 'toor';
        $user = User::create([
            'name' => 'root',
            'email' => 'root@localhost.com',
            'password' => bcrypt($password)
        ]);

        RegularUser::create([
            'idRegularUser' => $user->idUser
        ]);

        $category = Category::create([
            'name' => 'Hoodie One Punch Man'
        ]);

        $product = Product::create([
            'name' => 'Hoodie One Punch Man white',
            'description' => 'Hoodie One Punch Man',
            'price' => 1000,
            'amount' => 10,
            'image_path' => '1541002565.jpg',
            'active' => 1,
        ]);
        Product::find($product->idProduct)->categories()->attach($category->idCategory);
        $url = '/product-detail/'.strval($product->idProduct).'';

        //run with migration (slow) probar
        $this->browse(function ($browser) use ($user, $url){
             $browser->loginAs($user->idUser)
                     ->visit($url)
                     ->assertSee('Product Detail')
                     ->press('@post_botton')
                     ->assertSee('The comment field is required.');
        });

      
    }
    
     /**
     * @group comment
     */    
     public function testCommentProduct_ValidComment_ReturnCommentsInView()
     {
        if (\Auth::check()) auth()->logout();
        $password = 'toor';
        $user = User::create([
            'name' => 'root',
            'email' => 'root@localhost.com',
            'password' => bcrypt($password)
        ]);
        $category = Category::create([
            'name' => 'Hoodie naruto'
        ]);

        $product = Product::create([
            'name' => 'Hoodie One Punch Man white',
            'description' => 'Hoodie One Punch Man',
            'price' => 1000,
            'amount' => 10,
            'image_path' => '1541002565.jpg',
            'active' => 1,
        ]);
        Product::find($product->idProduct)->categories()->attach($category->idCategory);
        $url = '/product-detail/'.strval($product->idProduct).'';

        //run with migration (slow) probar
        $this->browse(function ($browser) use ($user, $url){
             $browser->loginAs($user->idUser)
                     ->visit($url)
                     ->assertSee('Product Detail')
                     ->type('comment','My first comment')
                     ->press('Post')
                     ->assertSee('My first comment')
                    ->assertSee($user->name);
        });

       
     }
 
     /**
     * @group comment
     */
     public function testCommentProduct_UnlogedUser_ReturnNoBottonPostInView()
     {
        if (\Auth::check()) auth()->logout();
        
        $category = Category::create([
            'name' => 'One Punch Man'
        ]);

        $product = Product::create([
            'name' => 'Hoodie One Punch Man white',
            'description' => 'Hoodie One Punch Man',
            'price' => 1000,
            'amount' => 10,
            'image_path' => '1541002565.jpg',
            'active' => 1,
        ]);
        Product::find($product->idProduct)->categories()->attach($category->idCategory);
        $url = '/product-detail/'.strval($product->idProduct).'';

        //run with migration (slow) probar
        $this->browse(function ($browser) use ($url){
             $browser->visit($url)
                     ->assertSee('Product Detail')
                     ->assertSee('Opinions')
                     ->assertMissing('@post_botton');
        });

     }
    

     /**
     * @group rate
     */
    //Aun falta ///////////////////// no sirve 
     public function testRateProduct_logedUser_ReturnProductInView()
     {
 
        if (\Auth::check()) auth()->logout();
        $password = 'toor';
        $user = User::create([
            'name' => 'root',
            'email' => 'root@localhost.com',
            'password' => bcrypt($password)
        ]);
        $category = Category::create([
            'name' => 'Hoodie One Punch Man'
        ]);

        $product = Product::create([
            'name' => 'Hoodie One Punch Man white',
            'description' => 'Hoodie One Punch Man',
            'price' => 1000,
            'amount' => 10,
            'image_path' => '1541002565.jpg',
            'active' => 1,
        ]);
        Product::find($product->idProduct)->categories()->attach($category->idCategory);
        $url = '/product-detail/'.strval($product->idProduct).'';

        //run with migration (slow) probar
        $this->browse(function ($browser) use ($user, $url){
             $browser->loginAs($user->idUser)
                    ->visit($url)
                    ->pause(1000)
                    ->radio('@star-rate-2-3', '3')
                    ->press('@rate-button-2')
                    ->visit($url)
                    ->assertRadioSelected('@star-rating-3', '3');
        });

        $this->assertDatabaseHas('rates', [
            'idUser' => $user->idUser,
        ]);
     }
 

     /**
     * @group rate1
     */
     public function testRateProduct_UnlogedUser_DontSeeBottonInView()
     {
         
        if (\Auth::check()) auth()->logout();
       
        $category = Category::create([
            'name' => 'Hoodie One Punch Man'
        ]);

        $product = Product::create([
            'name' => 'Hoodie One Punch Man white',
            'description' => 'Hoodie One Punch Man',
            'price' => 1000,
            'amount' => 10,
            'image_path' => '1540180603.jpg',
            'active' => 1,
        ]);
        Product::find($product->idProduct)->categories()->attach($category->idCategory);
        $url = '/product-detail/'.strval($product->idProduct).'';
        
        $this->browse(function ($browser) use ($url){
            $browser->visit($url)
                    ->assertSee('Product Detail')
                    ->assertSee('Opinions')
                    ->assertMissing('@rate_botton');
                    
        });

        
     }
 


}
