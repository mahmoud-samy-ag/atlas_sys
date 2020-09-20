<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coverage extends Model
{
    protected $fillable = [
        'doctor_id', 'creator_id'
    ];

  

    public function customer()
    {
        return $this->hasOne('App\Doctor' , 'id' , 'doctor_id');
    }

    public function address()
    {
        return $this->hasOne('App\AddressDoctor' , 'doctor_id' , 'doctor_id');
    }

    public function coverage_visiting()
    {
        return $this->hasMany('App\CoverageVisiting' , 'doctor_id' , 'doctor_id');
    }

    

}
