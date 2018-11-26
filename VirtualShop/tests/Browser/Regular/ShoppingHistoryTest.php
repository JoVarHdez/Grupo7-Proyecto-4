<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Product;
use App\RegularUser;
use App\Order;
use App\Cart;
use App\User;
use App\Category;

class ShoppingHistoryTest extends DuskTestCase
{
    use DatabaseMigrations;

         /**
         * @group havingOrders
         */
        public function testCheckPurchase_HavingOrders_ReturnOrdersInView()
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
                'name' => 'Hoodie naruto'
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
            
            $order = Order::create([
                'idUser' => $user -> idUser,
                'total' =>  $product -> price
            ]);

            Order::find($order->idOrder)->products()
                            ->attach($product ->idProduct, 
                            ["productQuantity" => 1]);

            $url = '/order/'.$user->idUser;
            
            $this->browse(function ($browser) use ($user, $order, $url){
                $browser->loginAs($user->idUser)
                        ->visit($url)
                        ->assertSee($order -> total);
            });

            $this->assertDatabaseHas('orders', [
                'idOrder' => $order->idOrder,
            ]);
        }

        public function testSearchOrder_OrderExists_ReturnSearchedOrderInView()
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
                'name' => 'Hoodie naruto'
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
            
            $order = Order::create([
                'idUser' => $user -> idUser,
                'total' =>  $product -> price
            ]);

            Order::find($order->idOrder)->products()
                            ->attach($product ->idProduct, 
                            ["productQuantity" => 1]);

            $url = '/order/'.$user->idUser;
            
            $this->browse(function ($browser) use ($user, $order, $url){
                $browser->loginAs($user->idUser)
                        ->visit($url)
                        ->type('orderId', $order->idOrder)
                        ->press('#Search_Orders')
                        ->assertSee($order -> total);
            });

            $this->assertDatabaseHas('orders', [
                'idOrder' => $order->idOrder,
            ]);
        }

        public function testSearchOrder_WithMultipleOrders_ReturnSingleSearchedOrderInView()
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
                'name' => 'Hoodie naruto'
            ]);

            $product = Product::create([
                'name' => 'Hoodie One Punch Man white',
                'description' => 'Hoodie One Punch Man',
                'price' => 1000,
                'amount' => 10,
                'image_path' => '1540180603.jpg',
                'active' => 1,
            ]);
            $product2 = Product::create([
                'name' => 'Hoodie Naruto white',
                'description' => 'Hoodie Naruto',
                'price' => 3000,
                'amount' => 40,
                'image_path' => '1540180603.jpg',
                'active' => 1,
            ]);

            Product::find($product->idProduct)->categories()->attach($category->idCategory);
            Product::find($product2->idProduct)->categories()->attach($category->idCategory);
            
            $order = Order::create([
                'idUser' => $user -> idUser,
                'total' =>  $product -> price
            ]);

            Order::find($order->idOrder)->products()
                            ->attach($product ->idProduct, 
                            ["productQuantity" => 1]);

            $order2 = Order::create([
                'idUser' => $user -> idUser,
                'total' =>  $product2 -> price
            ]);

            Order::find($order2->idOrder)->products()
                            ->attach($product2 ->idProduct, 
                            ["productQuantity" => 1]);

            $url = '/order/'.$user->idUser;
            
            $this->browse(function ($browser) use ($user, $order, $order2, $url){
                $browser->loginAs($user->idUser)
                        ->visit($url)
                        ->type('orderId', $order->idOrder)
                        ->press('#Search_Orders')
                        ->assertSee($order -> total)
                        ->assertDontSee($order2 -> total);
            });
        }

        public function testSearchOrder_OrderDoesntExists_ReturnSearchedOrderInView()
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
                'name' => 'Hoodie naruto'
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
            
            $order = Order::create([
                'idUser' => $user -> idUser,
                'total' =>  $product -> price
            ]);

            Order::find($order->idOrder)->products()
                            ->attach($product ->idProduct, 
                            ["productQuantity" => 1]);

            $url = '/order/'.$user->idUser;
            
            $this->browse(function ($browser) use ($user, $order, $url){
                $browser->loginAs($user->idUser)
                        ->visit($url)
                        ->type('orderId', 100)
                        ->press('#Search_Orders')
                        ->assertDontSee($order -> total);
            });
        }
    
        public function testSearchOrder_NoInput_ReturnsError()
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
                'name' => 'Hoodie naruto'
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
            
            $order = Order::create([
                'idUser' => $user -> idUser,
                'total' =>  $product -> price
            ]);

            Order::find($order->idOrder)->products()
                            ->attach($product ->idProduct, 
                            ["productQuantity" => 1]);

            $url = '/order/'.$user->idUser;
            
            $this->browse(function ($browser) use ($user, $order, $url){
                $browser->loginAs($user->idUser)
                        ->visit($url)
                        ->press('#Search_Orders')
                        ->assertSee('The order id field is required.');
            });
        }
}
