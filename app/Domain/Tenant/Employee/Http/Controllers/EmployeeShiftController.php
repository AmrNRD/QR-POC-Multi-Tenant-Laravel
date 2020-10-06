<?php

namespace App\Domain\Tenant\Employee\Http\Controllers;

use App\Domain\Tenant\Employee\Repositories\Contracts\EmployeeDevicesRepository;
use App\Domain\Tenant\Employee\Repositories\Contracts\EmployeeRepository;
use App\Domain\Tenant\Shift\Repositories\Contracts\ShiftRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use App\Domain\Tenant\Employee\Http\Requests\EmployeeShift\EmployeeShiftStoreFormRequest;
use App\Domain\Tenant\Employee\Http\Requests\EmployeeShift\EmployeeShiftUpdateFormRequest;
use App\Domain\Tenant\Employee\Repositories\Contracts\EmployeeShiftRepository;
use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Tenant\Employee\Entities\EmployeeShift;
use App\Domain\Tenant\Employee\Http\Resources\EmployeeShift\EmployeeShiftResourceCollection;
use App\Domain\Tenant\Employee\Http\Resources\EmployeeShift\EmployeeShiftResource;

class EmployeeShiftController extends Controller
{
    use Responder;

    /**
     * @var EmployeeShiftRepository
     */
    protected EmployeeShiftRepository $employeeShiftRepository;


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
    protected $viewPath = 'employee_shift';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'employee_shifts';

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'employees';


    /**
     * @param EmployeeShiftRepository $employeeShiftRepository
     * @param ShiftRepository $shiftRepository
     * @param EmployeeRepository $employeeRepository
     */
    public function __construct(EmployeeShiftRepository $employeeShiftRepository,ShiftRepository $shiftRepository,EmployeeRepository $employeeRepository)
    {
        $this->employeeShiftRepository = $employeeShiftRepository;
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
        $index = $this->employeeShiftRepository->spatie()->all();

        $this->setData('title', __('main.show-all') . ' ' . __('main.employee_shift'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(EmployeeShiftResourceCollection::class,'data');

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

        $this->setData('title', __('main.add') . ' ' . __('main.employee_shifts'), 'web');

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
    public function store(EmployeeShiftStoreFormRequest $request)
    {
        $store = $this->employeeShiftRepository->create($request->validated());

        if($store){
            $this->setData('data', $store);

            $this->redirectRoute("{$this->resourceRoute}.show",[$store->id]);
            $this->useCollection(EmployeeShiftResource::class, 'data');
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
    public function show(EmployeeShift $employee_shift)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.employee_shift') . ' : ' . $employee_shift->id, 'web');

        $this->setData('alias', $this->domainAlias,'web');

        $this->setData('show', $employee_shift);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(EmployeeShiftResource::class,'show');

        return $this->response();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param EmployeeShift $employee_shift
     * @return void
     */
    public function edit(EmployeeShift $employee_shift)
    {
        $employees = $this->employeeRepository->all();

        $shifts = $this->shiftRepository->all();

        $this->setData('title', __('main.edit') . ' ' . __('main.employee_shift') . ' : ' . $employee_shift->id, 'web');

        $this->setData('alias', $this->domainAlias,'web');

        $this->setData('employees', $employees,'web');

        $this->setData('shifts', $shifts,'web');


        $this->setData('edit', $employee_shift);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(EmployeeShiftResource::class,'edit');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeShiftUpdateFormRequest $request, $employee_shift)
    {
        $update = $this->employeeShiftRepository->update($request->validated(), $employee_shift);

        if($update){
            $this->redirectRoute("{$this->resourceRoute}.show",[$update->id]);
            $this->setData('data', $update);
            $this->useCollection(EmployeeShiftResource::class, 'data');
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

        $delete = $this->employeeShiftRepository->destroy($ids);

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
