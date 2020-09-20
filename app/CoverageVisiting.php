<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoverageVisiting extends Model
{
    protected $fillable = [
        'doctor_id','report_id'
    ];
}
