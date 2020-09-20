<?php

use Illuminate\Database\Seeder;

class Doctors extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1 ; $i <=40 ; $i++){
            $class='a';
            if(rand(1,3)==1){ $class='a'; }
            if(rand(1,3)==2){ $class='b'; }
            if(rand(1,3)==3){ $class='c'; }
            
            $kol=null;
            if(rand(1,4)==1){ $kol='kol'; }
            if(rand(1,4)==2){ $kol=null; }
            if(rand(1,4)==3){ $kol='kol'; }
            if(rand(1,4)==4){ $kol=null; }

            $user = \App\Doctor::create([
                'name' => 'Doctor'.$i,
                'spec' => 'Speciality'.$i,
                'category' => 'doctor',
                'class' => $class,
                'period' => 'pm',
                'kol' => $kol,
                'created_by' => rand(5,29),
            ]);
        }



        for($i=1 ; $i <=40 ; $i++){
            $cate='moh';
            if(rand(1,5)==1){ $cate='moh'; }
            if(rand(1,5)==2){ $cate='univ'; }
            if(rand(1,5)==3){ $cate='contract'; }
            if(rand(1,5)==4){ $cate='pr.hospital'; }
            if(rand(1,5)==5){ $cate='distributer'; }

            $user = \App\Doctor::create([
                'name' => 'hospital'.$i,
                'category' => 'hospital',
                'hospital_pharmacy_client' => 'hospital doctor'.$i,
                'hospital_category' => $cate,
                'period' => 'am',
                'created_by' => rand(5,29),
            ]);
        }







        for($i=1 ; $i <=40 ; $i++){
            $period='pm';
            if(rand(1,4)==1){ $period='pm'; }
            if(rand(1,4)==2){ $period='am'; }
            if(rand(1,4)==3){ $period='pm'; }
            if(rand(1,4)==4){ $period='am'; }
            $cate='moh';
            if(rand(1,5)==1){ $cate='moh'; }
            if(rand(1,5)==2){ $cate='univ'; }
            if(rand(1,5)==3){ $cate='contract'; }
            if(rand(1,5)==4){ $cate='pr.hospital'; }
            if(rand(1,5)==5){ $cate='distributer'; }

            $user = \App\Doctor::create([
                'name' => 'pharmacy'.$i,
                'category' => 'pharmacy',
                'hospital_pharmacy_client' => 'pharmacy doctor'.$i,
                'period' => $period,
                'created_by' => rand(5,29),
            ]);
        }









        for($i=120 ; $i >=1 ; $i--){
            
            $user = \App\AddressDoctor::create([
                'address_id' => rand(1,150),
                'doctor_id' => $i,
            ]);
        }



        


    }
}
