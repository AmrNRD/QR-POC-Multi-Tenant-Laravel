<?php

namespace App\Domain\Tenant\Employee\Entities;

use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Tenant\Employee\Entities\Traits\Relations\EmployeeDevicesRelations;
use App\Domain\Tenant\Employee\Entities\Traits\CustomAttributes\EmployeeDevicesAttributes;
use App\Domain\Tenant\Employee\Repositories\Contracts\EmployeeDevicesRepository;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class EmployeeDevices extends Model
{
    use EmployeeDevicesRelations, EmployeeDevicesAttributes,UsesTenantConnection;

    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'EmployeeDevices';

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
        'name'
    ];

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "employee_devices";

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = EmployeeDevicesRepository::class;
}
