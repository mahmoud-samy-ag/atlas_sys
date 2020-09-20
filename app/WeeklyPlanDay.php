<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeeklyPlanDay extends Model
{
    protected $fillable = [
        'plan_id', 'day_date','area','start_time','start_point' , 'product_specialist',
    ];

    
}
