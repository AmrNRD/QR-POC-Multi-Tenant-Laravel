<?php

namespace App\Domain\Tenant\Employee\Http\Controllers;

use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use App\Domain\Tenant\Employee\Http\Requests\Employee\EmployeeStoreFormRequest;
use App\Domain\Tenant\Employee\Http\Requests\Employee\EmployeeUpdateFormRequest;
use App\Domain\Tenant\Employee\Repositories\Contracts\EmployeeRepository;
use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Tenant\Employee\Entities\Employee;
use App\Domain\Tenant\Employee\Http\Resources\Employee\EmployeeResourceCollection;
use App\Domain\Tenant\Employee\Http\Resources\Employee\EmployeeResource;

class EmployeeController extends Controller
{
    use Responder;

    /**
     * @var EmployeeRepository
     */
    protected $employeeRepository;

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'employee';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'employees';

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'employees';


    /**
     * @param EmployeeRepository $employeeRepository
     */
    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $index = $this->employeeRepository->spatie()->all();

        $this->setData('title', __('main.show-all') . ' ' . __('main.employee'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(EmployeeResourceCollection::class,'data');

        return $this->response();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setData('title', __('main.add') . ' ' . __('main.employee'), 'web');

        $this->setData('alias', $this->domainAlias,'web');

        $this->addView("{$this->domainAlias}::{$this->viewPath}.create");

        $this->setApiResponse(fn()=> response()->json(['create_your_own_form'=>true]));

        return $this->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeStoreFormRequest $request)
    {
        $store = $this->employeeRepository->create($request->validated());

        if($store){
            $this->setData('data', $store);

            $this->redirectRoute("{$this->resourceRoute}.show",[$store->id]);
            $this->useCollection(EmployeeResource::class, 'data');
        }else{
            $this->redirectBack();
            $this->setApiResponse(fn()=> response()->json(['created'=>false]));
        }

        return $this->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.employee') . ' : ' . $employee->id, 'web');

        $this->setData('alias', $this->domainAlias,'web');

        $this->setData('show', $employee);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(EmployeeResource::class,'show');

        return $this->response();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $this->setData('title', __('main.edit') . ' ' . __('main.employee') . ' : ' . $employee->id, 'web');

        $this->setData('alias', $this->domainAlias,'web');

        $this->setData('edit', $employee);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(EmployeeResource::class,'edit');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeUpdateFormRequest $request, $employee)
    {
        $update = $this->employeeRepository->update($request->validated(), $employee);

        if($update){
            $this->redirectRoute("{$this->resourceRoute}.show",[$update->id]);
            $this->setData('data', $update);
            $this->useCollection(EmployeeResource::class, 'data');
        }else{
            $this->redirectBack();
            $this->setApiResponse(fn()=>response()->json(['updated'=>false],422));
        }

        return $this->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ids = request()->get('ids',[$id]);

        $delete = $this->employeeRepository->destroy($ids);

        if($delete){
            $this->redirectRoute("{$this->resourceRoute}.index");
            $this->setApiResponse(fn()=>response()->json(['deleted'=>true],200));
        }else{
            $this->redirectBack();
            $this->setApiResponse(fn()=>response()->json(['updated'=>false],422));
        }

        return $this->response();
    }

}
