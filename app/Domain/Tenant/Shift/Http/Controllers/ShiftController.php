<?php

namespace App\Domain\Tenant\Shift\Http\Controllers;

use App\Domain\Admin\Http\Resources\Admin\AdminResource;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use App\Domain\Tenant\Shift\Http\Requests\Shift\ShiftStoreFormRequest;
use App\Domain\Tenant\Shift\Http\Requests\Shift\ShiftUpdateFormRequest;
use App\Domain\Tenant\Shift\Repositories\Contracts\ShiftRepository;
use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Tenant\Shift\Entities\Shift;
use App\Domain\Tenant\Shift\Http\Resources\Shift\ShiftResourceCollection;
use App\Domain\Tenant\Shift\Http\Resources\Shift\ShiftResource;

class ShiftController extends Controller
{
    use Responder;

    /**
     * @var ShiftRepository
     */
    protected $shiftRepository;

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'shift';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'shifts';

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'shifts';


    /**
     * @param ShiftRepository $shiftRepository
     */
    public function __construct(ShiftRepository $shiftRepository)
    {
        $this->shiftRepository = $shiftRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $index = $this->shiftRepository->spatie()->all();

        $this->setData('title', __('main.show-all') . ' ' . __('main.shift'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(ShiftResourceCollection::class,'data');

        return $this->response();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setData('title', __('main.add') . ' ' . __('main.shift'), 'web');

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
    public function store(ShiftStoreFormRequest $request)
    {
        $store = $this->shiftRepository->create($request->validated());

        if($store){
            $this->setData('data', $store);

            $this->redirectRoute("{$this->resourceRoute}.show",[$store->id]);
            $this->setApiResponse(fn()=>response()->json(['data'=>new ShiftResource($store),'message'=>"created successfully"],201));
        }else{
            $this->redirectBack();
            $this->setApiResponse(fn()=> response()->json(['created'=>false]));
        }

        return $this->response();
    }

    /**
     * Display the specified resource.
     *
     * @param Shift $shift
     * @return void
     */
    public function show(Shift $shift)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.shift') . ' : ' . $shift->id, 'web');

        $this->setData('alias', $this->domainAlias,'web');

        $this->setData('show', $shift);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->setApiResponse(fn()=>response()->json(['data'=>new ShiftResource($shift),'message'=>"created successfully"],200));

        return $this->response();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Shift $shift)
    {
        $this->setData('title', __('main.edit') . ' ' . __('main.shift') . ' : ' . $shift->id, 'web');

        $this->setData('alias', $this->domainAlias,'web');

        $this->setData('edit', $shift);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(ShiftResource::class,'edit');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ShiftUpdateFormRequest $request, $shift)
    {
        $update = $this->shiftRepository->update($request->validated(), $shift);

        if($update){
            $this->redirectRoute("{$this->resourceRoute}.show",[$update->id]);
            $this->setData('data', $update);
            $this->setApiResponse(fn()=>response()->json(['data'=>new ShiftResource($update),'message'=>"created successfully"],200));
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

        $delete = $this->shiftRepository->destroy($ids);

        if($delete){
            $this->redirectRoute("{$this->resourceRoute}.index");
            $this->setApiResponse(fn()=>response()->json(['message'=>"deleted successfully"],201));
        }else{
            $this->redirectBack();
            $this->setApiResponse(fn()=>response()->json(['updated'=>false],422));
        }

        return $this->response();
    }

}
