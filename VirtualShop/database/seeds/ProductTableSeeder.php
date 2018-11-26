<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->delete();
        $product = new Product([
            'image_path' => 'https://images-na.ssl-images-amazon.com/images/I/71kgUS7jqHL._SX679_.jpg',
            'name' => 'Phone1',
            'price' => 10,
            'description' => 'The Greatest Phone',
            'amount' => 5,
            'active' => 1
        ]);
        $product -> save();

        $product = new Product([
            'image_path' => 'https://images-na.ssl-images-amazon.com/images/I/51Jq5vuWKFL.jpg',
            'name' => 'Phone2',
            'price' => 10,
            'description' => 'The Greatest Phone',
            'amount' => 5,
            'active' => 1
        ]);
        $product -> save();

        $product = new Product([
            'image_path' => 'https://images-na.ssl-images-amazon.com/images/I/81qiCrJlzgL._SX679_.jpg',
            'name' => 'Phone3',
            'price' => 10,
            'description' => 'The Greatest Phone',
            'amount' => 5,
            'active' => 1
        ]);
        $product -> save();
    }
}
