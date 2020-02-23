<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarEvents extends Model
{
    protected $fillable = [
        'event_name','start_date', 'end_date'
    ];

    public function weekdays()
    {
        return $this->hasOne('App\Weekdays');
    }
}
