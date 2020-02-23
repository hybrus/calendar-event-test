<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WeekdaysResource extends JsonResource
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
            '0'=>$this->sun,
            '1'=>$this->mon,
            '2'=>$this->tue,
            '3'=>$this->wed,
            '4'=>$this->thu,
            '5'=>$this->fri,
            '6'=>$this->sat
        ];
    }
}
