<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddressDoctor extends Model
{
    protected $fillable = [
        'address_id', 'doctor_id'
    ];
}
