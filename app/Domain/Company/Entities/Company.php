<?php

namespace App\Domain\Company\Entities;

use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Company\Entities\Traits\Relations\CompanyRelations;
use App\Domain\Company\Entities\Traits\CustomAttributes\CompanyAttributes;
use App\Domain\Company\Repositories\Contracts\CompanyRepository;

class Company extends Model
{
    use CompanyRelations, CompanyAttributes;

    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Company';

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
        'name',
        'email',
        'address',
        'active',
    ];

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "companies";

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = CompanyRepository::class;
}
