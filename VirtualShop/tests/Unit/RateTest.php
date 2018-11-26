<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Product;
use App\User;
use App\RegularUser;
use App\Category;
use App\Rate;
use DB;

class RateTest extends TestCase
{
	use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */

    public function setup() {
    	parent::setUp();
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

        if (\Auth::check()) auth()->logout();
        $password = 'toor';
        $user2 = User::create([
        'name' => 'root_2',
        'email' => 'root_2@localhost.com',
        'password' => bcrypt($password)
        ]);

        RegularUser::create([
        'idRegularUser' => $user2->idUser
        ]);

    	$category = Category::create([
            'name' => 'Hoodie naruto'
        ]);

        $category2 = Category::create([
            'name' => 'Hoodie bleach'
        ]);

        $product = Product::create([
            'name' => 'Hoodie naruto jonin',
            'description' => 'Hoodie naruto jonin ',
            'price' => 10000,
            'amount' => 100,
            'image_path' => '1541002565.jpg',
            'active' => 1,
        ]);

        $product2 = Product::create([
            'name' => 'Hoodie bleach bankai',
            'description' => 'Hoodie bleach ban-kai form ',
            'price' => 15000,
            'amount' => 100,
            'image_path' => '1541002565.jpg',
            'active' => 1,
        ]);

        $product3 = Product::create([
            'name' => 'Hoodie naruto hokage',
            'description' => 'Hoodie naruto hokage ',
            'price' => 13000,
            'amount' => 100,
            'image_path' => '1541002565.jpg',
            'active' => 1,
        ]);

        Product::find($product->idProduct)->categories()->attach($category->idCategory);
        Product::find($product2->idProduct)->categories()->attach($category2->idCategory);
        Product::find($product3->idProduct)->categories()->attach($category->idCategory);

        $newRate =  Rate::create([
            'idUser' => $user->idUser,
        	'idProduct' => $product->idProduct,
        	'rate' => '2',
        ]);

        $newRate2 =  Rate::create([
            'idUser' => $user->idUser,
        	'idProduct' => $product2->idProduct,
        	'rate' => '5',
        ]);

        $newRate3 =  Rate::create([
            'idUser' => $user->idUser,
        	'idProduct' => $product3->idProduct,
        	'rate' => '1',
        ]);

        $newRat4 =  Rate::create([
            'idUser' => $user2->idUser,
        	'idProduct' => $product->idProduct,
        	'rate' => '4',
        ]);

        $newRate5 =  Rate::create([
            'idUser' => $user2->idUser,
        	'idProduct' => $product2->idProduct,
        	'rate' => '5',
        ]);

        $newRate6 =  Rate::create([
            'idUser' => $user2->idUser,
        	'idProduct' => $product3->idProduct,
        	'rate' => '3',
        ]);
    }

    public function testRateOrder_MultiplePrductsRated_ReturningSecondProduct()
    {
    	$ratingSQL = DB::select('Select AVG(r.rate) as Rating FROM rates r GROUP by r.idProduct Order by rating DESC;')[0]->rating;
        $this->assertEquals($ratingSQL,5.0000);
    }
}
