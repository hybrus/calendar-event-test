<?php

namespace App\Http\Controllers;

use App\CalendarEvents;
use App\Http\Resources\CalendarEventResource;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;

class CalendarEventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CalendarEventResource::collection(CalendarEvents::with('weekdays')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $data = CalendarEvents::updateOrCreate(
            ['event_name' => $req->event_name],
            ['start_date' => $req->start_date,'end_date' => $req->end_date]
        );

        $data->weekdays()->updateOrCreate(['calendar_events_id' => $data->id], $req->weekdays);

        return CalendarEventResource::collection(CalendarEvents::with('weekdays')->get());

    }
}
