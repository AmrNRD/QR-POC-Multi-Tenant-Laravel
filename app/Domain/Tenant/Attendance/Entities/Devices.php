<?php

namespace App\Domain\Tenant\Attendance\Entities;

use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Tenant\Attendance\Entities\Traits\Relations\DevicesRelations;
use App\Domain\Tenant\Attendance\Entities\Traits\CustomAttributes\DevicesAttributes;
use App\Domain\Tenant\Attendance\Repositories\Contracts\DevicesRepository;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Device extends Model
{
    use DevicesRelations, DevicesAttributes,UsesTenantConnection;

    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Devices';

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
        'firebase_token','qr_code','device_type','device_details','last_active_request','user_id','created_at','updated_at','active'
    ];

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "devices";

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = DevicesRepository::class;
}
