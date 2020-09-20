<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarketFeedback extends Model
{
    protected $fillable = [
        'creator_id',
        'doctor_id',
        'feedback_type',
        'complaint',
        'others',
        'feedback_details',
        'expected_effect',
        'suggestions', 
        'products',
    ];
}
