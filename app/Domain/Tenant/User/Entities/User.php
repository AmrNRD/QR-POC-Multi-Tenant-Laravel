<?php

namespace App\Domain\Tenant\User\Entities;

use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Tenant\User\Entities\Traits\Relations\UserRelations;
use App\Domain\Tenant\User\Entities\Traits\CustomAttributes\UserAttributes;
use App\Domain\Tenant\User\Repositories\Contracts\UserRepository;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Laravel\Passport\HasApiTokens;
use Joovlly\Authorizable\Models\User as Authorizable;
use Illuminate\Notifications\Notifiable;

class User extends Authorizable
{
    use Notifiable, UserRelations, UserAttributes,UsesTenantConnection,HasApiTokens;

    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'User';

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
        'password',
        'active',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = UserRepository::class;
}
