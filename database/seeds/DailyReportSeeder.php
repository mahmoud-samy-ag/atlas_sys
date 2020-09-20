<?php

use Illuminate\Database\Seeder;

class DailyReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1 ; $i <=150 ; $i++){
            $user = \App\DailyReport::create([
                'creator_id' => rand(5,29),
            ]);

                

            $doc_rand=rand(1,5);

            for($a=1 ; $a <=$doc_rand ; $a++){
                $doc_id=rand(1,120);
                $user = \App\DailyReportDoctor::create([
                    'report_id' => $i,
                    'doctor_id' => $doc_id,
                ]);

                $prod_rand=rand(1,5);
                for($b=1 ; $b <=$prod_rand ; $b++){
                    $user = \App\DailyReportDoctorProduct::create([
                        'report_id' => $i,
                        'doctor_id' => $doc_id,
                        'product_id' => rand(1,15),
                        'feedback' => 'feedback'.$b,
                    ]);
                }


            }

        }

        

        
    }
}
