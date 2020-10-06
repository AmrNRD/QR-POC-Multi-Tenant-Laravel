<?php

namespace App\Domain\Tenant\Employee\Entities\Traits\Relations;

use App\Domain\Tenant\Employee\Entities\EmployeeDevices;
use App\Domain\Tenant\Employee\Entities\EmployeeShift;
use App\Domain\Tenant\User\Entities\User;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\MorphedByMany;

trait EmployeeRelations
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignedShifts()
    {
        return $this->hasMany(EmployeeShift::class,'employee_id','id');
    }

    public function devices(){
        return $this->hasMany(EmployeeDevices::class,'employee_id','id');
    }
}
