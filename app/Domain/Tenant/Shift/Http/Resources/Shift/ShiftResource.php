<?php

namespace App\Domain\Tenant\Shift\Http\Resources\Shift;

use Illuminate\Http\Request;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;

class ShiftResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function data(Request $request):array
    {
        return [
            'id'               => $this->id,
            'name'             => $this->name,
            'type'             => $this->type,
            'start_from'             => $this->start_from,
            'end_from'             => $this->end_from,
            'start_date'             => $this->start_date,
            'end_date'             => $this->end_date,

        ];
    }
}
