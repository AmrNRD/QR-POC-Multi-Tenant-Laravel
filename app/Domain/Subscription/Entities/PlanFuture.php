<?php

namespace App\Domain\Subscription\Entities;

use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Subscription\Entities\Traits\Relations\PlanFutureRelations;
use App\Domain\Subscription\Entities\Traits\CustomAttributes\PlanFutureAttributes;
use App\Domain\Subscription\Repositories\Contracts\PlanFutureRepository;

class PlanFuture extends Model
{
    use PlanFutureRelations, PlanFutureAttributes;

    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'PlanFuture';

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
    protected $table = "plan_futures";

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = PlanFutureRepository::class;
}
