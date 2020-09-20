<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoverageVisitingProduct extends Model
{
    protected $fillable = [
        'visiting_id', 'product_id', 'report_id'
    ];
}
