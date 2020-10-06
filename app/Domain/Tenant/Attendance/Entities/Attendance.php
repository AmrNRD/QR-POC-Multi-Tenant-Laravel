<?php

namespace App\Domain\Tenant\Attendance\Entities;

use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Tenant\Attendance\Entities\Traits\Relations\AttendanceRelations;
use App\Domain\Tenant\Attendance\Entities\Traits\CustomAttributes\AttendanceAttributes;
use App\Domain\Tenant\Attendance\Repositories\Contracts\AttendanceRepository;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Attendance extends Model
{
    use AttendanceRelations, AttendanceAttributes,UsesTenantConnection;

    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Attendance';

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
        'employee_id','employee_shift_id','date','check_in','check_out','shift_start','shift_end','status'
    ];

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "attendances";

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = AttendanceRepository::class;
}
