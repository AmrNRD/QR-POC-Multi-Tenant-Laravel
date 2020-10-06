<?php

namespace App\Domain\Tenant\Attendance\Http\Controllers;

use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use App\Domain\Tenant\Attendance\Http\Requests\Holidays\HolidaysStoreFormRequest;
use App\Domain\Tenant\Attendance\Http\Requests\Holidays\HolidaysUpdateFormRequest;
use App\Domain\Tenant\Attendance\Repositories\Contracts\HolidaysRepository;
use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Tenant\Attendance\Entities\Holidays;
use App\Domain\Tenant\Attendance\Http\Resources\Holidays\HolidaysResourceCollection;
use App\Domain\Tenant\Attendance\Http\Resources\Holidays\HolidaysResource;

class HolidaysController extends Controller
{
    use Responder;

    /**
     * @var HolidaysRepository
     */
    protected HolidaysRepository $holidaysRepository;

    /**
     * View Path
     *
     * @var string
     */
    protected string $viewPath = 'holidays';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected string $resourceRoute = 'holidays';

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected string $domainAlias = 'attendances';


    /**
     * @param HolidaysRepository $holidaysRepository
     */
    public function __construct(HolidaysRepository $holidaysRepository)
    {
        $this->holidaysRepository = $holidaysRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $index = $this->holidaysRepository->spatie()->all();

        $this->setData('title', __('main.show-all') . ' ' . __('main.holidays'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(HolidaysResourceCollection::class,'data');

        return $this->response();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setData('title', __('main.add') . ' ' . __('main.holidays'), 'web');

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
    public function store(HolidaysStoreFormRequest $request)
    {
        $store = $this->holidaysRepository->create($request->validated());

        if($store){
            $this->setData('data', $store);

            $this->redirectRoute("{$this->resourceRoute}.show",[$store->id]);
            $this->useCollection(HolidaysResource::class, 'data');
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
    public function show(Holidays $holidays)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.holidays') . ' : ' . $holidays->id, 'web');

        $this->setData('alias', $this->domainAlias,'web');

        $this->setData('show', $holidays);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(HolidaysResource::class,'show');

        return $this->response();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Holidays $holidays
     * @return \Illuminate\Http\Response
     */
    public function edit(Holidays $holidays)
    {
        $this->setData('title', __('main.edit') . ' ' . __('main.holidays') . ' : ' . $holidays->id, 'web');

        $this->setData('alias', $this->domainAlias,'web');

        $this->setData('edit', $holidays);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(HolidaysResource::class,'edit');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param HolidaysUpdateFormRequest $request
     * @param $holidays
     * @return \Illuminate\Http\Response
     */
    public function update(HolidaysUpdateFormRequest $request, $holidays)
    {
        $update = $this->holidaysRepository->update($request->validated(), $holidays);

        if($update){
            $this->redirectRoute("{$this->resourceRoute}.show",[$update->id]);
            $this->setData('data', $update);
            $this->useCollection(HolidaysResource::class, 'data');
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

        $delete = $this->holidaysRepository->destroy($ids);

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
