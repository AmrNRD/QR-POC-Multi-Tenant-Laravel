<?php

namespace App\Domain\Admin\Http\Resources\Role;

use Illuminate\Http\Request;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;

class RoleResource extends JsonResource
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
            'permissions'      => $this->permissions
        ];
    }
}
