<?php

namespace App\Domain\Tenant\Shift\Entities;

use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Tenant\Shift\Entities\Traits\Relations\ShiftRelations;
use App\Domain\Tenant\Shift\Entities\Traits\CustomAttributes\ShiftAttributes;
use App\Domain\Tenant\Shift\Repositories\Contracts\ShiftRepository;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Shift extends Model
{
    use ShiftRelations, ShiftAttributes,UsesTenantConnection;

    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Shift';

    /**
     * define belongsTo relations.
     *
     * @var array
     */
    private $belongsTo = [];

    /**
     * define belongsTo relations.
     *
     * @var array
     */
    protected  $dates=['start_date','end_date','created_at','updated_at'];

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
        'name','type','threshold','start_at','end_at','start_date','end_date'
    ];

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "shifts";

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = ShiftRepository::class;
}
