<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeeklyPlan extends Model
{
    protected $fillable = [
        'name', 'user_id' , 'start_at' , 'end_at'
    ];

    public function creator()
    {
        return $this->hasOne('App\User' , 'id' , 'user_id');
    }

    public function day()
    {
        return $this->hasMany('App\WeeklyPlanDay' , 'plan_id' , 'id');
    }

    public function doctor()
    {
        return $this->hasMany('App\WeeklyPlanDayDoctor' , 'plan_id' , 'id');
    }
}
