<?php
namespace App\Domain\Admin\Repositories\Eloquent;

use App\Domain\Admin\Entities\Admin;
use App\Domain\Admin\Repositories\Contracts\AdminRepository;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Contracts\Container\Container as Application;

class AdminRepositoryEloquent extends BaseRepository implements AdminRepository
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
        'email_verified_at',
        'active',
###\allowedFields###
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

    /**
     * Create New Entity.
     *
     * @param  array $data
     * @return Model
     */
    public function create(array $data) {
        $data['password'] = Hash::make($data['password']);
        return parent::create($data);
    }

    /**
     * Allowed Appends.
     *
     * @var array
     */
    protected $allowedAppends = [];

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
     * @inheritDoc
     */
    public function model()
    {
        return Admin::class;
    }
}
