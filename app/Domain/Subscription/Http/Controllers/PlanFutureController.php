<?php

namespace App\Domain\Subscription\Http\Controllers;

use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use App\Domain\Subscription\Http\Requests\PlanFuture\PlanFutureStoreFormRequest;
use App\Domain\Subscription\Http\Requests\PlanFuture\PlanFutureUpdateFormRequest;
use App\Domain\Subscription\Repositories\Contracts\PlanFutureRepository;
use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Subscription\Entities\PlanFuture;
use App\Domain\Subscription\Http\Resources\PlanFuture\PlanFutureResourceCollection;
use App\Domain\Subscription\Http\Resources\PlanFuture\PlanFutureResource;

class PlanFutureController extends Controller
{
    use Responder;
    
    /**
     * @var PlanFutureRepository
     */
    protected $planFutureRepository;

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'plan_future';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'plan_futures';

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'subscriptions';


    /**
     * @param PlanFutureRepository $planFutureRepository
     */
    public function __construct(PlanFutureRepository $planFutureRepository)
    {
        $this->planFutureRepository = $planFutureRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $index = $this->planFutureRepository->spatie()->all();

        $this->setData('title', __('main.show-all') . ' ' . __('main.plan_future'));

        $this->setData('alias', $this->domainAlias);
        
        $this->setData('data', $index);
        
        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(PlanFutureResourceCollection::class,'data');

        return $this->response();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setData('title', __('main.add') . ' ' . __('main.plan_future'), 'web');

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
    public function store(PlanFutureStoreFormRequest $request)
    {
        $store = $this->planFutureRepository->create($request->validated());

        if($store){
            $this->setData('data', $store);
            
            $this->redirectRoute("{$this->resourceRoute}.show",[$store->id]);
            $this->useCollection(PlanFutureResource::class, 'data');
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
    public function show(PlanFuture $plan_future)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.plan_future') . ' : ' . $plan_future->id, 'web');

        $this->setData('alias', $this->domainAlias,'web');
        
        $this->setData('show', $plan_future);
        
        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(PlanFutureResource::class,'show');

        return $this->response();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PlanFuture $plan_future)
    {
        $this->setData('title', __('main.edit') . ' ' . __('main.plan_future') . ' : ' . $plan_future->id, 'web');

        $this->setData('alias', $this->domainAlias,'web');
        
        $this->setData('edit', $plan_future);
        
        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(PlanFutureResource::class,'edit');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PlanFutureUpdateFormRequest $request, $plan_future)
    {
        $update = $this->planFutureRepository->update($request->validated(), $plan_future);
        
        if($update){
            $this->redirectRoute("{$this->resourceRoute}.show",[$update->id]);
            $this->setData('data', $update);
            $this->useCollection(PlanFutureResource::class, 'data');
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

        $delete = $this->planFutureRepository->destroy($ids);

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
