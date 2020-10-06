<?php

namespace App\Domain\Tenant\Attendance\Http\Controllers;

use App\Domain\Admin\Http\Resources\Admin\AdminResource;
use App\Domain\Tenant\Attendance\Http\Requests\Devices\DevicesActivateFormRequest;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use App\Domain\Tenant\Attendance\Http\Requests\Devices\DevicesStoreFormRequest;
use App\Domain\Tenant\Attendance\Http\Requests\Devices\DevicesUpdateFormRequest;
use App\Domain\Tenant\Attendance\Repositories\Contracts\DevicesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Tenant\Attendance\Entities\Device;
use App\Domain\Tenant\Attendance\Http\Resources\Devices\DevicesResourceCollection;
use App\Domain\Tenant\Attendance\Http\Resources\Devices\DevicesResource;

class DevicesController extends Controller
{
    use Responder,\SendPushNotification;

    /**
     * @var DevicesRepository
     */
    protected DevicesRepository $devicesRepository;

    /**
     * View Path
     *
     * @var string
     */
    protected string $viewPath = 'devices';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected string $resourceRoute = 'devices';

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected string $domainAlias = 'attendances';


    /**
     * @param DevicesRepository $devicesRepository
     */
    public function __construct(DevicesRepository $devicesRepository)
    {
        $this->devicesRepository = $devicesRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $index = $this->devicesRepository->spatie()->all();

        $this->setData('title', __('main.show-all') . ' ' . __('main.devices'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(DevicesResourceCollection::class,'data');

        return $this->response();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setData('title', __('main.add') . ' ' . __('main.devices'), 'web');

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
    public function store(DevicesStoreFormRequest $request)
    {
        $store = $this->devicesRepository->create($request->validated());

        if($store){
            $this->setData('data', $store);

            $this->redirectRoute("{$this->resourceRoute}.show",[$store->id]);
            $this->useCollection(DevicesResource::class, 'data');
        }else{
            $this->redirectBack();
            $this->setApiResponse(fn()=> response()->json(['created'=>false]));
        }

        return $this->response();
    }

    /**
     * Display the specified resource.
     *
     * @param Device $devices
     * @return void
     */
    public function show(Device $devices)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.devices') . ' : ' . $devices->id, 'web');

        $this->setData('alias', $this->domainAlias,'web');

        $this->setData('show', $devices);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(DevicesResource::class,'show');

        return $this->response();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DevicesUpdateFormRequest $request, $devices)
    {
        $update = $this->devicesRepository->update($request->validated(), $devices);

        if($update){
            $this->redirectRoute("{$this->resourceRoute}.show",[$update->id]);
            $this->setData('data', $update);
            $this->useCollection(DevicesResource::class, 'data');
        }else{
            $this->redirectBack();
            $this->setApiResponse(fn()=>response()->json(['updated'=>false],422));
        }

        return $this->response();
    }


    /**
     * Activate or deactivate the specified resource in storage.
     *
     * @param DevicesActivateFormRequest $request
     * @param $device
     * @return void
     */
    public function activateDevice(DevicesActivateFormRequest $request,int $device)
    {
        $update = $this->devicesRepository->update($request->validated(), $device);
        if($update){
            $this->sendNotificationToAdmin("Device ".$request->active,[$update->firebase_token],["device"=>new DevicesResource($update)]);
            $this->redirectRoute("{$this->resourceRoute}.show",[$update->id]);
            $this->setData('data', $update);
            $this->setApiResponse(fn()=>response()->json(['data'=>new DevicesResource($update),'message'=>"updated successfully"],200));
        }else{
            $this->redirectBack();
            $this->setApiResponse(fn()=>response()->json(['message'=>'Was not updated successfully'],422));
        }

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateQR(Request $request)
    {
        $firebase_token=$request->firebase_token;
        $device=$this->devicesRepository->findWhere(['firebase_token'=>$firebase_token])->first();
        if ($device){
            $updated_device=$this->devicesRepository->update(['qr_code'=>Str::random(15)],$device->id);
            return  response()->json(['status'=>'Updated','device'=>new DevicesResource($updated_device)]);
        }else{
            return  response()->json(['status'=>'Failed','message'=>'Device not found'],401);
        }
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

        $delete = $this->devicesRepository->destroy($ids);

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
