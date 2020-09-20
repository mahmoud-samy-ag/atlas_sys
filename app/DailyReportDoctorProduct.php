<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyReportDoctorProduct extends Model
{
    protected $fillable = [
        'doctor_id', 'product_id' , 'report_id'
    ];
}
