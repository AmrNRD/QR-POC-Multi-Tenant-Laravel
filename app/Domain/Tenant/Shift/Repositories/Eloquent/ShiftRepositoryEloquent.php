<?php
namespace App\Domain\Tenant\Shift\Repositories\Eloquent;

use App\Domain\Tenant\Shift\Entities\Shift;
use App\Domain\Tenant\Shift\Repositories\Contracts\ShiftRepository;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Contracts\Container\Container as Application;

class ShiftRepositoryEloquent  extends BaseRepository  implements ShiftRepository
{
    /**
     * Allowed Relations To Be Included.
     *
     * @var array
     */
    protected $allowedIncludes = [];

    /**
     * Allowed Fields To Be Filtered [partial word].
     *
     * @var array
     */
    protected $allowedFilters = [
        'name',
        'type',
        'threshold',
        'start_at',
        'end_at',
        'start_date',
        'end_date'
    ];

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
     * Allowed Fields.
     *
     * @var array
     */
    protected $allowedFields = [
        'name',
        'type',
        'threshold',
        'start_at',
        'end_at',
        'start_date',
        'end_date'
    ];

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
     * @inheritDoc
     */
    public function model()
    {
        return Shift::class;
    }
}
