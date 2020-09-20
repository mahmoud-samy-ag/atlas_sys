<?php

use Illuminate\Database\Seeder;

class Areas extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1 ; $i <=15 ; $i++){

            $user = \App\Area::create([
                'name' => 'region'.$i,
                'for' => 'regional_manager',
            ]);
        }

        for($i=1 ; $i <=15 ; $i++){

            $user = \App\Area::create([
                'name' => 'area'.$i,
                'for' => 'district_manager',
            ]);
        }

        for($i=1 ; $i <=15 ; $i++){

            $user = \App\Area::create([
                'name' => 'location'.$i,
                'for' => 'product_specialist',
            ]);
        }
    }
}
