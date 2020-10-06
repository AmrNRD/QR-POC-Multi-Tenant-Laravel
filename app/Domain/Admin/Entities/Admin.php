<?php

namespace App\Domain\Admin\Entities;

use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Admin\Entities\Traits\Relations\AdminRelations;
use App\Domain\Admin\Entities\Traits\CustomAttributes\AdminAttributes;
use App\Domain\Admin\Repositories\Contracts\AdminRepository;
use Illuminate\Notifications\Notifiable;
use Joovlly\Authorizable\Models\User as Authorizable;

class Admin extends Authorizable
{
    use Notifiable, AdminRelations, AdminAttributes;

    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Admin';

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
        'company_id',
        'email_verified_at',
        'permissions' => 'array',
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
        'permissions' => 'array',
        'email_verified_at' => 'datetime',
    ];

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "admins";

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = AdminRepository::class;
}
