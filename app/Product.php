<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
    ];

    public function product_feedbacks()
    {
        return $this->hasMany('App\DailyReportDoctorProduct' , 'product_id');
    }
}
