<?php

namespace App\Domain\Tenant\User\Http\Services;

use App\Domain\Admin\Entities\Admin;
use App\Domain\Admin\Repositories\Contracts\AdminRepository;
use App\Domain\Admin\Repositories\Contracts\RoleRepository;
use App\Domain\Tenant\Attendance\Entities\Device;
use App\Domain\Tenant\Attendance\Repositories\Contracts\DevicesRepository;
use App\Domain\Tenant\Employee\Entities\EmployeeDevices;
use App\Domain\Tenant\Employee\Repositories\Contracts\EmployeeDevicesRepository;
use App\Domain\Tenant\User\Entities\User;
use App\Domain\Tenant\User\Repositories\Contracts\UserRepository;
use Illuminate\Support\Arr;

/**
 * Class RegisterDeviceService.
 *
 * @package namespace App\Domain\User\Services;
 */
class RegisterUserService
{
    /**
     * @var UserRepository
     */
    protected UserRepository $userRepository;

    /**
     * @var RoleRepository
     */
    protected RoleRepository $roleRepository;

    public function __construct(UserRepository $userRepository,RoleRepository $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository=$roleRepository;
    }

    /**
     * @param array $data
     * @return User
     */
    public function register(array $data):User
    {
        $role_id=$data['role_id'];
        $admin=$this->userRepository->create(Arr::except($data, ['role_id']));
        $role=$this->roleRepository->findWhere(["id"=>$role_id])->first();
        $admin->roles()->attach($role);
        return $admin;
    }


}
