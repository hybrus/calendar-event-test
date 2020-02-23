<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CalendarEventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title'=>$this->event_name,
            'start'=>$this->start_date,
            'end'=>$this->end_date,
            'weekdays'=>new WeekdaysResource($this->whenLoaded('weekdays'))
        ];
    }
}
