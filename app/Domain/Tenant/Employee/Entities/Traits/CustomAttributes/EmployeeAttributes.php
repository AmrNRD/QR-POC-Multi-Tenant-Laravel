<?php

namespace App\Domain\Tenant\Employee\Entities\Traits\CustomAttributes;

trait EmployeeAttributes
{

    public function getImageAttribute(){
        return asset($this->photo);
    }

    public function getLastAssignedShift()
    {
        return $this->assignedShift->last();
    }

}
