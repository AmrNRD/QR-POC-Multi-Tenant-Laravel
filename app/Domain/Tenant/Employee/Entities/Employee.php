<?php

namespace App\Domain\Tenant\Employee\Entities;

use App\Domain\Tenant\Employee\Entities\Traits\CustomAttributes\EmployeeAttributes;
use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Tenant\Employee\Entities\Traits\Relations\EmployeeRelations;
use App\Domain\Tenant\Employee\Repositories\Contracts\EmployeeRepository;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Employee extends Model
{
    use EmployeeRelations, EmployeeAttributes,UsesTenantConnection;

    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Employee';

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
        'user_id','photo','date_of_birth','address','gender'
    ];

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "employees";

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = EmployeeRepository::class;
}
