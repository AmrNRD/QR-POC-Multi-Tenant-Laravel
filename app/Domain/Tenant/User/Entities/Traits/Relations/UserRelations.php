<?php

namespace App\Domain\Tenant\User\Entities\Traits\Relations;

use App\Domain\Tenant\Attendance\Entities\Device;
use App\Domain\Tenant\Employee\Entities\Employee;
use App\Domain\Tenant\Employee\Entities\EmployeeDevices;
use App\Domain\Tenant\User\Entities\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\MorphedByMany;

trait UserRelations
{

    /**
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            Role::class,
            'role_user',
            'user_id',
            'role_id'
        );
    }

    /**
     * @return HasOne
     */
    public function employee():HasOne
    {
        return $this->hasOne(Employee::class);
    }

    /**
     * @return HasOne
     */
    public function devices():HasOne
    {
        return $this->hasMany(Device::class,'user_id','id');
    }
}
