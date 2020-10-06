<?php
namespace App\Common\Criteria;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class AuthEmployeeCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('employee_id','=', Auth::user()->employee->id );
        return $model;
    }
}
