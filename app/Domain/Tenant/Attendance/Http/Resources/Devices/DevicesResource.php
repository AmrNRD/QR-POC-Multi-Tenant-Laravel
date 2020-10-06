<?php

namespace App\Domain\Tenant\Attendance\Http\Resources\Devices;

use Illuminate\Http\Request;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;

class DevicesResource extends JsonResource
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
            'qr_code'             => $this->qr_code,
            'firebase_token'             => $this->firebase_token,
            'device_type'             => $this->device_type,
            'active'             => $this->active,
        ];
    }
}
