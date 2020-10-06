<?php

namespace App\Domain\Tenant\Employee\Http\Controllers;

use App\Domain\Tenant\Employee\Repositories\Contracts\EmployeeRepository;
use App\Domain\Tenant\Shift\Repositories\Contracts\ShiftRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use App\Domain\Tenant\Employee\Http\Requests\EmployeeDevices\EmployeeDevicesStoreFormRequest;
use App\Domain\Tenant\Employee\Http\Requests\EmployeeDevices\EmployeeDevicesUpdateFormRequest;
use App\Domain\Tenant\Employee\Repositories\Contracts\EmployeeDevicesRepository;
use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Tenant\Employee\Entities\EmployeeDevices;
use App\Domain\Tenant\Employee\Http\Resources\EmployeeDevices\EmployeeDevicesResourceCollection;
use App\Domain\Tenant\Employee\Http\Resources\EmployeeDevices\EmployeeDevicesResource;

class EmployeeDevicesController extends Controller
{
    use Responder;

    /**
     * @var EmployeeDevicesRepository
     */
    protected EmployeeDevicesRepository $employeeDevicesRepository;


    /**
     * @var ShiftRepository
     */
    protected ShiftRepository $shiftRepository;

    /**
     * @var EmployeeRepository
     */
    protected EmployeeRepository $employeeRepository;

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'employee_devices';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'employee_devices';

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'employees';


    /**
     * @param EmployeeDevicesRepository $employeeDevicesRepository
     * @param ShiftRepository $shiftRepository
     * @param EmployeeRepository $employeeRepository
     */
    public function __construct(EmployeeDevicesRepository $employeeDevicesRepository,ShiftRepository $shiftRepository,EmployeeRepository $employeeRepository)
    {
        $this->employeeDevicesRepository = $employeeDevicesRepository;
        $this->employeeRepository=$employeeRepository;
        $this->shiftRepository=$shiftRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $index = $this->employeeDevicesRepository->spatie()->all();

        $this->setData('title', __('main.show-all') . ' ' . __('main.employee_devices'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(EmployeeDevicesResourceCollection::class,'data');

        return $this->response();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = $this->employeeRepository->all();

        $shifts = $this->shiftRepository->all();

        $this->setData('title', __('main.add') . ' ' . __('main.employee_devices'), 'web');

        $this->setData('employees', $employees,'web');

        $this->setData('shifts', $shifts,'web');

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
    public function store(EmployeeDevicesStoreFormRequest $request)
    {
        $store = $this->employeeDevicesRepository->create($request->validated());

        if($store){
            $this->setData('data', $store);

            $this->redirectRoute("{$this->resourceRoute}.show",[$store->id]);
            $this->useCollection(EmployeeDevicesResource::class, 'data');
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
    public function show(EmployeeDevices $employee_devices)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.employee_devices') . ' : ' . $employee_devices->id, 'web');

        $this->setData('alias', $this->domainAlias,'web');

        $this->setData('show', $employee_devices);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(EmployeeDevicesResource::class,'show');

        return $this->response();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param EmployeeDevices $employee_devices
     * @return void
     */
    public function edit(EmployeeDevices $employee_devices)
    {
        $employees = $this->employeeRepository->all();

        $shifts = $this->shiftRepository->all();

        $this->setData('title', __('main.edit') . ' ' . __('main.employee_devices') . ' : ' . $employee_devices->id, 'web');

        $this->setData('employees', $employees,'web');

        $this->setData('shifts', $shifts,'web');

        $this->setData('alias', $this->domainAlias,'web');

        $this->setData('edit', $employee_devices);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(EmployeeDevicesResource::class,'edit');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeDevicesUpdateFormRequest $request, $employee_devices)
    {
        $update = $this->employeeDevicesRepository->update($request->validated(), $employee_devices);

        if($update){
            $this->redirectRoute("{$this->resourceRoute}.show",[$update->id]);
            $this->setData('data', $update);
            $this->useCollection(EmployeeDevicesResource::class, 'data');
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

        $delete = $this->employeeDevicesRepository->destroy($ids);

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
