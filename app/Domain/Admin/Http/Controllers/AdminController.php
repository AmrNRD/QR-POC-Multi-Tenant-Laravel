<?php

namespace App\Domain\Admin\Http\Controllers;

use App\Domain\Admin\Repositories\Contracts\RoleRepository;
use App\Domain\Company\Repositories\Contracts\CompanyRepository;
use App\Domain\Tenant\User\Http\Services\RegisterAdminService;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use App\Domain\Admin\Http\Requests\Admin\AdminStoreFormRequest;
use App\Domain\Admin\Http\Requests\Admin\AdminUpdateFormRequest;
use App\Domain\Admin\Repositories\Contracts\AdminRepository;
use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Admin\Entities\Admin;
use App\Domain\Admin\Http\Resources\Admin\AdminResourceCollection;
use App\Domain\Admin\Http\Resources\Admin\AdminResource;

class AdminController extends Controller
{
    use Responder;

    /**
     * @var AdminRepository
     */
    protected AdminRepository $adminRepository;


    /**
     * @var CompanyRepository
     */
    protected CompanyRepository $companyRepository;

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
    protected $viewPath = 'admin';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'admins';

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'admins';


    /**
     * @param AdminRepository $adminRepository
     * @param CompanyRepository $companyRepository
     * @param RoleRepository $roleRepository
     */
    public function __construct(AdminRepository $adminRepository,CompanyRepository $companyRepository,RoleRepository $roleRepository,RegisterAdminService $registerAdminService)
    {
        $this->adminRepository = $adminRepository;
        $this->companyRepository=$companyRepository;
        $this->roleRepository=$roleRepository;
        $this->registerAdminService=$registerAdminService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $index = $this->adminRepository->spatie()->all();

        $this->setData('title', __('main.show-all') . ' ' . __('main.admin'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(AdminResource::collection($index),'data');

        return $this->response();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = $this->companyRepository->all();

        $roles = $this->roleRepository->all();

        $this->setData('title', __('main.add') . ' ' . __('main.admin'), 'web');

        $this->setData('alias', $this->domainAlias,'web');

        $this->setData('companies', $companies,'web');

        $this->setData('roles', $roles,'web');

        $this->addView("{$this->domainAlias}::{$this->viewPath}.create");


        return $this->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminStoreFormRequest $request)
    {

        $store = $this->registerAdminService->register($request->validated());

        if($store){
            $this->setData('data', $store);

            $this->redirectRoute("{$this->resourceRoute}.show",[$store->id]);

            $this->setApiResponse(fn()=>response()->json(['data'=>new AdminResource($store),'message'=>"created successfully"],201));
        }else{
            $this->redirectBack();
            $this->setApiResponse(fn()=> response()->json(['created'=>false]));
        }

        return $this->response();
    }

    /**
     * Display the specified resource.
     *
     * @param Admin $admin
     * @return void
     */
    public function show(Admin $admin)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.admin') . ' : ' . $admin->id, 'web');

        $this->setData('alias', $this->domainAlias,'web');

        $this->setData('show', $admin);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->setApiResponse(fn()=>response()->json(['data'=>new AdminResource($admin)],200));

        return $this->response();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        $companies = $this->companyRepository->all();

        $roles = $this->roleRepository->all();

        $this->setData('title', __('main.edit') . ' ' . __('main.admin') . ' : ' . $admin->id, 'web');

        $this->setData('alias', $this->domainAlias,'web');

        $this->setData('companies', $companies,'web');

        $this->setData('roles', $roles,'web');

        $this->setData('edit', $admin);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(AdminResource::class,'edit');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUpdateFormRequest $request, $admin)
    {
        $update = $this->adminRepository->update($request->validated(), $admin);
        if($update){
            $this->redirectRoute("{$this->resourceRoute}.show",[$update->id]);
            $this->setData('data', $update);
            $this->setApiResponse(fn()=>response()->json(['data'=>new AdminResource($update),'message'=>"updated successfully"],200));
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

        $delete = $this->adminRepository->destroy($ids);

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
