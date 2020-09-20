<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyReportDoctor extends Model
{

    protected $fillable = [
        'report_id', 'doctor_id', 'comm_and_feed',
    ];


    public function product_ids()
    {
        return $this->hasMany('App\DailyReportDoctorProduct' ,'doctor_id');
    }


}
