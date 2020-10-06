<?php

namespace App\Domain\User\Services;
use App\Domain\Tenant\Attendance\Entities\Device;
use App\Domain\Tenant\Attendance\Repositories\Contracts\DevicesRepository;
use App\Domain\Tenant\Employee\Entities\EmployeeDevices;
use App\Domain\Tenant\Employee\Repositories\Contracts\EmployeeDevicesRepository;
use App\Domain\Tenant\Employee\Repositories\Contracts\EmployeeRepository;
use App\Domain\Tenant\User\Entities\User;

/**
 * Class RegisterDeviceService.
 *
 * @package namespace App\Domain\User\Services;
 */
class RegisterEmployeeDeviceService {

    /**
     * @var EmployeeRepository
     */
    protected EmployeeRepository $employeeRepository;
    /**
     * @var EmployeeDevicesRepository
     */
    protected EmployeeDevicesRepository $employeeDevicesRepository;

	public function __construct(EmployeeDevicesRepository $employeeDevicesRepository,EmployeeRepository $employeeRepository) {
        $this->employeeDevicesRepository=$employeeDevicesRepository;
        $this->employeeRepository=$employeeRepository;
	}


    /**
     * @param User $user
     * @param string $type
     * @param String|null $firebase_token
     * @param String|null $platform
     * @return  EmployeeDevices $device
     */
    public function register(User $user, String $firebase_token = null, String $platform = null): EmployeeDevices
    {
         $employee=$this->employeeRepository->findWhere(['user_id'=>$user->id])->first();
        if ($firebase_token!=null&$employee!=null) {
            $device = $this->employeeDevicesRepository->findWhere(['firebase_token' => $firebase_token])->first();
            if ($device == null) {
                $device = $this->employeeDevicesRepository->create(['employee_id' => $employee->id, 'device_type' => $platform, 'firebase_token' => $firebase_token]);
            } else if ($device->employee_id != $employee->id) {
                $device = $this->employeeDevicesRepository->update(['employee_id' => $employee->id], $device->id);
            }
            return $device;
        }
        return null;
    }
}
