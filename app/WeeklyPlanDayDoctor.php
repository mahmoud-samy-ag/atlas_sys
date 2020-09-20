<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeeklyPlanDayDoctor extends Model
{
    protected $fillable = [
        'plan_id', 'day_id', 'doctor_id'
    ];
}
