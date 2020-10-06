<?php

namespace App\Domain\Tenant\Attendance\Http\Resources\Attendance;

use Illuminate\Http\Request;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;

class AttendanceResource extends JsonResource
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
            'date'             => $this->date,
            'check_in'         =>$this->check_in,
            'check_out'        =>$this->check_out,
            'shift_start'      =>$this->shift_start,
            'shift_end'        =>$this->shift_end,
            'status'           =>$this->status
        ];
    }
}
