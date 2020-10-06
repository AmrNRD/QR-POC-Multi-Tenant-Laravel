<?php

namespace App\Domain\Company\Http\Controllers;

use App\Domain\Admin\Repositories\Contracts\RoleRepository;
use App\Domain\Company\jobs\CreateTenantJob;
use App\Domain\Tenant\Attendance\Http\Requests\Devices\CompanyActivateFormRequest;
use App\Domain\Tenant\Attendance\Http\Requests\Devices\DevicesActivateFormRequest;
use App\Domain\Tenant\Attendance\Http\Resources\Devices\DevicesResource;
use App\Domain\Tenant\User\Http\Services\RegisterAdminService;
use App\Domain\Tenant\User\Repositories\Contracts\UserRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use App\Domain\Company\Http\Requests\Company\CompanyStoreFormRequest;
use App\Domain\Company\Http\Requests\Company\CompanyUpdateFormRequest;
use App\Domain\Company\Repositories\Contracts\CompanyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Company\Entities\Company;
use App\Domain\Company\Http\Resources\Company\CompanyResourceCollection;
use App\Domain\Company\Http\Resources\Company\CompanyResource;

class CompanyController extends Controller
{
    use Responder;

    /**
     * @var CompanyRepository
     */
    protected CompanyRepository $companyRepository;

    /**
     * @var UserRepository
     */
    protected UserRepository $userRepository;

    /**
     * @var RoleRepository
     */
    protected RoleRepository $roleRepository;


    /**
     * @var RegisterAdminService
     */
    protected RegisterAdminService $registerAdminService;




    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'company';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'companies';

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'companies';


    /**
     * @param CompanyRepository $companyRepository
     * @param RoleRepository $roleRepository
     * @param RegisterAdminService $registerAdminService
     * @param UserRepository $userRepository
     */
    public function __construct(CompanyRepository $companyRepository,RoleRepository $roleRepository,RegisterAdminService $registerAdminService,UserRepository $userRepository)
    {
        $this->companyRepository = $companyRepository;
        $this->roleRepository=$roleRepository;
        $this->userRepository=$userRepository;
        $this->registerAdminService=$registerAdminService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $index = $this->companyRepository->spatie()->all();

        $this->setData('title', __('main.show-all') . ' ' . __('main.company'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(CompanyResourceCollection::class,'data');

        return $this->response();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setData('title', __('main.add') . ' ' . __('main.company'), 'web');

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
    public function store(CompanyStoreFormRequest $request)
    {
        $data=$request->validated();
        $admin_data=$data["admin"];

        $store = $this->companyRepository->create(Arr::except($data,"admin"));

        if($store){
            $role=$this->roleRepository->findWhere(["slug"=>'CompanyAdmin'])->first();
            $admin=$this->registerAdminService->register($admin_data+["role_id"=>$role->id,"company_id"=>$store->id]);
            Artisan::call('tenant:create' ,[ 'company'=>$store->id ,'admin'=> $admin->id]);

            $this->setData('data', $store);

            $this->redirectRoute("{$this->resourceRoute}.show",[$store->id]);
            $this->useCollection(CompanyResource::class, 'data');
        }else{
            $this->redirectBack();
            $this->setApiResponse(fn()=> response()->json(['created'=>false]));
        }

        return $this->response();
    }

    /**
     * Display the specified resource.
     *
     * @param Company $company
     * @return void
     */
    public function show(Company $company)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.company') . ' : ' . $company->id, 'web');

        $this->setData('alias', $this->domainAlias,'web');

        $this->setData('show', $company);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(CompanyResource::class,'show');

        return $this->response();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Company $company
     * @return void
     */
    public function edit(Company $company)
    {
        $this->setData('title', __('main.edit') . ' ' . __('main.company') . ' : ' . $company->id, 'web');

        $this->setData('alias', $this->domainAlias,'web');

        $this->setData('edit', $company);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(CompanyResource::class,'edit');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyUpdateFormRequest $request, $company)
    {
        $update = $this->companyRepository->update($request->validated(), $company);

        if($update){
            $this->redirectRoute("{$this->resourceRoute}.show",[$update->id]);
            $this->setData('data', $update);
            $this->useCollection(CompanyResource::class, 'data');
        }else{
            $this->redirectBack();
            $this->setApiResponse(fn()=>response()->json(['updated'=>false],422));
        }

        return $this->response();
    }


    /**
     * Activate or deactivate the specified resource in storage.
     *
     * @param CompanyActivateFormRequest $request
     * @param $device
     * @return void
     */
    public function activateCompany(CompanyActivateFormRequest $request,int $device)
    {
        $update = $this->companyRepository->update($request->validated(), $device);
        if($update){
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ids = request()->get('ids',[$id]);

        $delete = $this->companyRepository->destroy($ids);

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
