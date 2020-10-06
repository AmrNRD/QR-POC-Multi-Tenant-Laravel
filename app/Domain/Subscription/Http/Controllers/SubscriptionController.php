<?php

namespace App\Domain\Subscription\Http\Controllers;

use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use App\Domain\Subscription\Http\Requests\Subscription\SubscriptionStoreFormRequest;
use App\Domain\Subscription\Http\Requests\Subscription\SubscriptionUpdateFormRequest;
use App\Domain\Subscription\Repositories\Contracts\SubscriptionRepository;
use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Subscription\Entities\Subscription;
use App\Domain\Subscription\Http\Resources\Subscription\SubscriptionResourceCollection;
use App\Domain\Subscription\Http\Resources\Subscription\SubscriptionResource;

class SubscriptionController extends Controller
{
    use Responder;
    
    /**
     * @var SubscriptionRepository
     */
    protected $subscriptionRepository;

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'subscription';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'subscriptions';

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'subscriptions';


    /**
     * @param SubscriptionRepository $subscriptionRepository
     */
    public function __construct(SubscriptionRepository $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $index = $this->subscriptionRepository->spatie()->all();

        $this->setData('title', __('main.show-all') . ' ' . __('main.subscription'));

        $this->setData('alias', $this->domainAlias);
        
        $this->setData('data', $index);
        
        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(SubscriptionResourceCollection::class,'data');

        return $this->response();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setData('title', __('main.add') . ' ' . __('main.subscription'), 'web');

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
    public function store(SubscriptionStoreFormRequest $request)
    {
        $store = $this->subscriptionRepository->create($request->validated());

        if($store){
            $this->setData('data', $store);
            
            $this->redirectRoute("{$this->resourceRoute}.show",[$store->id]);
            $this->useCollection(SubscriptionResource::class, 'data');
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
    public function show(Subscription $subscription)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.subscription') . ' : ' . $subscription->id, 'web');

        $this->setData('alias', $this->domainAlias,'web');
        
        $this->setData('show', $subscription);
        
        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(SubscriptionResource::class,'show');

        return $this->response();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscription $subscription)
    {
        $this->setData('title', __('main.edit') . ' ' . __('main.subscription') . ' : ' . $subscription->id, 'web');

        $this->setData('alias', $this->domainAlias,'web');
        
        $this->setData('edit', $subscription);
        
        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(SubscriptionResource::class,'edit');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubscriptionUpdateFormRequest $request, $subscription)
    {
        $update = $this->subscriptionRepository->update($request->validated(), $subscription);
        
        if($update){
            $this->redirectRoute("{$this->resourceRoute}.show",[$update->id]);
            $this->setData('data', $update);
            $this->useCollection(SubscriptionResource::class, 'data');
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

        $delete = $this->subscriptionRepository->destroy($ids);

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
