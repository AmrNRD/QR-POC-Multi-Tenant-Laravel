<?php
namespace App\Domain\Tenant\User\Repositories\Eloquent;

use App\Domain\Tenant\User\Entities\User;
use App\Domain\Tenant\User\Repositories\Contracts\UserRepository;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Contracts\Container\Container as Application;

class UserRepositoryEloquent extends BaseRepository implements UserRepository
{

    /**
     * Specify Fields
     *
     * @return string
     */
    protected $allowedFields = [
        ###allowedFields###
        'id',
        'name',
        'email',
        'password',
        'active',
        'email_verified_at',
        'permissions',
###\allowedFields###
    ];

    /**
     *
     * @return string
     */
    protected $allowedFilters = [
        'id',
        'name',
        'email',
        'password',
        'active',
        'email_verified_at',
        'permissions',
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

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Specify Model Relationships
     *
     * @return array
     */
    public function relations()
    {
        return [
            ###allowedRelations###
            ###\allowedRelations###
        ];
    }
    /**
     * Allowed Relations to be filterd [exact world].
     *
     * @var array
     */
    protected $allowedFiltersExact = [];

    /**
     * Create Custom Filtration Field.
     *
     * @var array
     */
    protected $customFiltrationRules = [];


    /**
     * Allowed Appends.
     *
     * @var array
     */
    protected $allowedAppends = [];

    /**
     * Allowed Sorts.
     *
     * @var array
     */
    protected $allowedSorts = [];

    /**
     * @param Application $app
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
     * Create New Entity.
     *
     * @param array $data
     * @return Model
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create(array $data) {
        $data['password'] = Hash::make($data['password']);
        return parent::create($data);
    }


    /**
     * Update Entity.
     *
     * @param  array $data
     * @param  integer $id
     * @return Model
     */
    public function update(array $data, $id) {

        return tap($this->find($id), function ($entity) use ($data) {
            if (isset($data['password']) && checkVar($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            return $entity->update($data);
        });
    }
}
