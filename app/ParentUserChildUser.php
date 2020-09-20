<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParentUserChildUser extends Model
{
    protected $fillable = [
        'parent_id', 'child_id',
    ];

    
}
