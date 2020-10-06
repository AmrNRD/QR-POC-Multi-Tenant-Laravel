<?php

namespace App\Domain\Subscription\Http\Controllers;

use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use App\Domain\Subscription\Http\Requests\Plan\PlanStoreFormRequest;
use App\Domain\Subscription\Http\Requests\Plan\PlanUpdateFormRequest;
use App\Domain\Subscription\Repositories\Contracts\PlanRepository;
use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Subscription\Entities\Plan;
use App\Domain\Subscription\Http\Resources\Plan\PlanResourceCollection;
use App\Domain\Subscription\Http\Resources\Plan\PlanResource;

class PlanController extends Controller
{
    use Responder;
    
    /**
     * @var PlanRepository
     */
    protected $planRepository;

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'plan';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'plans';

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'subscriptions';


    /**
     * @param PlanRepository $planRepository
     */
    public function __construct(PlanRepository $planRepository)
    {
        $this->planRepository = $planRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $index = $this->planRepository->spatie()->all();

        $this->setData('title', __('main.show-all') . ' ' . __('main.plan'));

        $this->setData('alias', $this->domainAlias);
        
        $this->setData('data', $index);
        
        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(PlanResourceCollection::class,'data');

        return $this->response();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setData('title', __('main.add') . ' ' . __('main.plan'), 'web');

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
    public function store(PlanStoreFormRequest $request)
    {
        $store = $this->planRepository->create($request->validated());

        if($store){
            $this->setData('data', $store);
            
            $this->redirectRoute("{$this->resourceRoute}.show",[$store->id]);
            $this->useCollection(PlanResource::class, 'data');
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
    public function show(Plan $plan)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.plan') . ' : ' . $plan->id, 'web');

        $this->setData('alias', $this->domainAlias,'web');
        
        $this->setData('show', $plan);
        
        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(PlanResource::class,'show');

        return $this->response();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Plan $plan)
    {
        $this->setData('title', __('main.edit') . ' ' . __('main.plan') . ' : ' . $plan->id, 'web');

        $this->setData('alias', $this->domainAlias,'web');
        
        $this->setData('edit', $plan);
        
        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(PlanResource::class,'edit');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PlanUpdateFormRequest $request, $plan)
    {
        $update = $this->planRepository->update($request->validated(), $plan);
        
        if($update){
            $this->redirectRoute("{$this->resourceRoute}.show",[$update->id]);
            $this->setData('data', $update);
            $this->useCollection(PlanResource::class, 'data');
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

        $delete = $this->planRepository->destroy($ids);

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
