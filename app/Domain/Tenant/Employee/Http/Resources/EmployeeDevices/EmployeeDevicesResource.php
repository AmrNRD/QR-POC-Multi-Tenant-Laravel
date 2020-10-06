<?php

namespace App\Domain\Tenant\Employee\Http\Resources\EmployeeDevices;

use Illuminate\Http\Request;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;

class EmployeeDevicesResource extends JsonResource
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
        ];
    }
}
