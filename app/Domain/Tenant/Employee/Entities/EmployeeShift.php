<?php

namespace App\Domain\Tenant\Employee\Entities;

use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Tenant\Employee\Entities\Traits\Relations\EmployeeShiftRelations;
use App\Domain\Tenant\Employee\Entities\Traits\CustomAttributes\EmployeeShiftAttributes;
use App\Domain\Tenant\Employee\Repositories\Contracts\EmployeeShiftRepository;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class EmployeeShift extends Model
{
    use EmployeeShiftRelations, EmployeeShiftAttributes,UsesTenantConnection;

    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'EmployeeShift';

    /**
     * define belongsTo relations.
     *
     * @var array
     */
    private $belongsTo = [];

    /**
     * define hasMany relations.
     *
     * @var array
     */
    private $hasMany = [];

    /**
     * define belongsToMany relations.
     *
     * @var array
     */
    private $belongsToMany = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id','shift_id','from','to'
    ];

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "employee_shifts";

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = EmployeeShiftRepository::class;
}
