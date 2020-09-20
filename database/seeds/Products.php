<?php

use Illuminate\Database\Seeder;

class Products extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1 ; $i <=15 ; $i++){
            $user = \App\Product::create([
                'name' => 'product'.$i,
            ]);
        }
    }
}
