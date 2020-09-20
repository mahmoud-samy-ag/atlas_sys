<?php

use Illuminate\Database\Seeder;

class Addresses extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1 ; $i <=150 ; $i++){
            $user = \App\Address::create([
                'name' => 'Customer Address'.$i,
                'creator_id' => rand(5,29),
            ]);
        }
    }
}
