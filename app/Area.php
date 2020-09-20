<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = [
        'name', 'for',
    ];


    public function user_id()
    {
        return $this->hasMany('App\area_user');
    }
    

}
