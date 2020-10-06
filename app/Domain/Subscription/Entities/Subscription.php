<?php

namespace App\Domain\Subscription\Entities;

use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Subscription\Entities\Traits\Relations\SubscriptionRelations;
use App\Domain\Subscription\Entities\Traits\CustomAttributes\SubscriptionAttributes;
use App\Domain\Subscription\Repositories\Contracts\SubscriptionRepository;

class Subscription extends Model
{
    use SubscriptionRelations, SubscriptionAttributes;

    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Subscription';

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
    protected $table = "subscriptions";

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = SubscriptionRepository::class;
}
