<?php

namespace App\Domain\Tenant\Attendance\Entities;

use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Tenant\Attendance\Entities\Traits\Relations\HolidaysRelations;
use App\Domain\Tenant\Attendance\Entities\Traits\CustomAttributes\HolidaysAttributes;
use App\Domain\Tenant\Attendance\Repositories\Contracts\HolidaysRepository;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Holidays extends Model
{
    use HolidaysRelations, HolidaysAttributes,UsesTenantConnection;

    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Holidays';

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
    protected $table = "holidays";

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = HolidaysRepository::class;
}
