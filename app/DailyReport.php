<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    protected $fillable = [
        'creator_id',
    ];

    public function doctor_ids()
    {
        return $this->hasMany('App\DailyReportDoctor' ,'report_id');
    }


}
