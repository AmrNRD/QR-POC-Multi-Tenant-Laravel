<?php

namespace App\Domain\Tenant\User\Entities;

use App\Domain\User\Entities\Traits\Relations\RoleRelations;
use App\Domain\User\Entities\Traits\CustomAttributes\RoleAttributes;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Joovlly\Authorizable\Models\Role as Model;

class Role extends Model
{
    use RoleRelations, RoleAttributes,UsesTenantConnection;

    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Role';

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
        'slug',
        'permissions',
        'activation'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'permissions' => 'array',
    ];

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "roles";

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = RoleRepository::class;
}
