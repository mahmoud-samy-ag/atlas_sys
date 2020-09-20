<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'name', 'approve', 'spec','class', 'visiting_time', 'period','kol', 'category', 'hospital_pharmacy_client', 'hospital_category',  'created_by'
    ];

    public function addresses()
    {
        return $this->belongsToMany('App\Address' , 'address_doctors');
    }

    public function creators()
    {
        return $this->hasOne('App\User' , 'id' , 'created_by');
    }

    public function product_feedback()
    {
        return $this->hasMany('App\DailyReportDoctorProduct' , 'doctor_id');
    }
}
