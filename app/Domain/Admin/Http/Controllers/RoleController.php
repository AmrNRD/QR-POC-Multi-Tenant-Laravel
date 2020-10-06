<?php

namespace App\Domain\Admin\Http\Controllers;

use App\Domain\Admin\Http\Resources\Admin\AdminResource;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use App\Domain\Admin\Http\Requests\Role\RoleStoreFormRequest;
use App\Domain\Admin\Http\Requests\Role\RoleUpdateFormRequest;
use App\Domain\Admin\Repositories\Contracts\RoleRepository;
use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Admin\Entities\Role;
use App\Domain\Admin\Http\Resources\Role\RoleResourceCollection;
use App\Domain\Admin\Http\Resources\Role\RoleResource;

class RoleController extends Controller
{
    use Responder;

    /**
     * @var RoleRepository
     */
    protected $roleRepository;

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'role';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'roles';

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'admins';


    /**
     * @param RoleRepository $roleRepository
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $index = $this->roleRepository->spatie()->all();

        $this->setData('title', __('main.show-all') . ' ' . __('main.role'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(RoleResourceCollection::class,'data');

        return $this->response();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = $this->roleRepository->first()->permissions;
        $this->setData('title', __('main.add') . ' ' . __('main.role'), 'web');

        $this->setData('alias', $this->domainAlias,'web');

        $this->setData('permissions', $permissions,'web');

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
    public function store(RoleStoreFormRequest $request)
    {
        $store = $this->roleRepository->create($request->validated());

        if($store){
            $this->setData('data', $store);

            $this->redirectRoute("{$this->resourceRoute}.show",[$store->id]);
            $this->setApiResponse(fn()=>response()->json(['data'=>new RoleResource($store),'message'=>"created successfully"],201));
        }else{
            $this->redirectBack();
            $this->setApiResponse(fn()=> response()->json(['created'=>false]));
        }

        return $this->response();
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @return void
     */
    public function show(Role $role)
    {

        $this->setData('title', __('main.show') . ' ' . __('main.role') . ' : ' . $role->id, 'web');

        $this->setData('alias', $this->domainAlias,'web');

        $this->setData('show', $role);


        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->setApiResponse(fn()=>response()->json(['data'=>new RoleResource($role)],200));

        return $this->response();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = $role->permissions;

        $this->setData('title', __('main.edit') . ' ' . __('main.role') . ' : ' . $role->id, 'web');

        $this->setData('alias', $this->domainAlias,'web');

        $this->setData('edit', $role);

        $this->setData('permissions', $permissions,'web');

        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(RoleResource::class,'edit');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUpdateFormRequest $request, $role)
    {
        $update = $this->roleRepository->update($request->validated(), $role);

        if($update){
            $this->redirectRoute("{$this->resourceRoute}.show",[$update->id]);
            $this->setData('data', $update);
            $this->setApiResponse(fn()=>response()->json(['data'=>new RoleResource($update),'message'=>"updated successfully"],200));
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

        $delete = $this->roleRepository->destroy($ids);

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
