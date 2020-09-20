<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::create([
            'name' => 'Admin',
            'email' => 'super_admin@app.com',
            'job_title' => 'CEO',
            'password' => bcrypt('123123'),
        ]);
        $user->attachRole('ceo');


        for($i=1 ; $i <=3 ; $i++){
            $user = \App\User::create([
                'name' => 'Regional Manager'.$i,
                'email' => 'rm@rm.com'.$i,
                'job_title' => 'Regional Manager',
                'password' => bcrypt('123'),
            ]);
            $user->attachRole('regional_manager');
        }

        for($i=1 ; $i <=10 ; $i++){
            $user = \App\User::create([
                'name' => 'distrect manager'.$i,
                'email' => 'dm@dm.com'.$i,
                'job_title' => 'District Manager',
                'password' => bcrypt('123'),
            ]);
            $user->attachRole('district_manager');
        }

       

        for($i=1 ; $i <=15 ; $i++){
            $user = \App\User::create([
                'name' => 'product specialist'.$i,
                'email' => 'ps@ps.com'.$i,
                'job_title' => 'Product Specialist',
                'password' => bcrypt('123'),
            ]);
            $user->attachRole('product_specialist');
        }


        for($i=1 ; $i <=10 ; $i++){
            $user = \App\ParentUserChildUser::create([
                'parent_id' => rand(2,4),
                'child_id' => ($i+4),
            ]);
        }


        for($i=1 ; $i <=15 ; $i++){
            $user = \App\ParentUserChildUser::create([
                'parent_id' => rand(5,14),
                'child_id' => ($i+14),
            ]);
        }


        $user = \App\User::create([
            'name' => 'Salse Manager',
            'email' => 'sales@manager.com',
            'job_title' => 'Sales Manager',
            'password' => bcrypt('123'),
        ]);
        $user->attachRole('sales_manager');

        $user = \App\User::create([
            'name' => 'General Manager',
            'email' => 'general@manager.com',
            'job_title' => 'General Manager',
            'password' => bcrypt('123'),
        ]);
        $user->attachRole('general_manager');
       

        

        
    }
}
