<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Weekdays extends Model
{
    protected $fillable=[
        'sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'
    ];
    
    public function calendarEvent()
    {   
        return $this->belongsTo('App\CalendarEvents');
    }
}
