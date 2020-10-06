<?php

namespace App\Domain\Tenant\Attendance\Entities\Traits\Relations;

use App\Domain\Tenant\Employee\Entities\Employee;
use App\Domain\Tenant\Employee\Entities\EmployeeShift;
use App\Domain\Tenant\Shift\Entities\Shift;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\MorphedByMany;

trait AttendanceRelations
{
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function employeeShift()
    {
        return $this->belongsTo(EmployeeShift::class);
    }



}
