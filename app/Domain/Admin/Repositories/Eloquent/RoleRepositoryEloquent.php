<?php

namespace App\Domain\Admin\Repositories\Eloquent;

use App\Domain\Admin\Repositories\Contracts\RoleRepository;
use App\Domain\Admin\Entities\Role;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class RoleRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RoleRepositoryEloquent extends BaseRepository implements RoleRepository
{

    /**
     * Specify Fields
     *
     * @return string
     */
    protected $allowedFields = [
        'id',
        'name',
        'slug',
        'permissions',
        'active'
    ];

    /**
     * Include Relationships
     *
     * @return string
     */
    protected $allowedIncludes = [
        ###allowedIncludes###
        ###\allowedIncludes###
    ];

    protected $allowedFilters = [];

    /**
     * Allowed Relations to be filterd [exact world].
     *
     * @var array
     */
    protected $allowedFiltersExact = [];

    protected $customFiltrationRules = [];


    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Role::class;
    }


    /**
     */
    public function spatie()
    {
        foreach ($this->allowedFiltersExact as $field) {
            array_push($this->allowedFilters,AllowedFilter::exact($field));
        }

        foreach ($this->customFiltrationRules as $key => $handler) {
            array_push($this->allowedFilters,AllowedFilter::custom($key, new $handler));
        }

        if ($this->model instanceof Builder) {
            $this->model = QueryBuilder::for($this->model)
                ->allowedFields($this->allowedFields)
                ->allowedFilters($this->allowedFilters)
                ->allowedIncludes($this->allowedIncludes);
        } else {
            $query = app()->make($this->model())->newQuery();
            $this->model = QueryBuilder::for($query)
                ->allowedFields($this->allowedFields)
                ->allowedFilters($this->allowedFilters)
                ->allowedIncludes($this->allowedIncludes);
        }
        return $this;
    }

    /**
     * Specify Model Relationships
     *
     * @return string
     */
    public function relations()
    {
        return [
            ###allowedRelations###
            ###\allowedRelations###
        ];
    }
}
