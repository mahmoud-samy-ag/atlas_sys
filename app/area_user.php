<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class area_user extends Model
{
    protected $fillable = [
        'area_id', 'user_id'
    ];
}
