<?php

namespace App\Domain\Tenant\User\Http\Services;

use App\Domain\Tenant\Attendance\Entities\Device;
use App\Domain\Tenant\Attendance\Repositories\Contracts\DevicesRepository;
use App\Domain\Tenant\Employee\Entities\EmployeeDevices;
use App\Domain\Tenant\Employee\Repositories\Contracts\EmployeeDevicesRepository;
use App\Domain\Tenant\User\Entities\User;

/**
 * Class RegisterDeviceService.
 *
 * @package namespace App\Domain\User\Services;
 */
class RegisterDeviceService
{
    /**
     * @var DevicesRepository
     */
    protected $devicesRepository;

    public function __construct(DevicesRepository $devicesRepository)
    {
        $this->devicesRepository = $devicesRepository;
    }

    /**
     * @param User $user
     * @param String|null $firebase_token
     * @param String|null $platform
     * @return Device $device
     */
    public function register(User $user,String $firebase_token = null, String $platform = null):Device
    {

        if ($firebase_token != null) {
            $device = $this->devicesRepository->findWhere(['firebase_token' => $firebase_token])->first();
            if ($device == null) {
                $device = $this->devicesRepository->create(['user_id' => $user->id, 'device_type' => $platform, 'firebase_token' => $firebase_token]);
            } else if ($device->user_id != $user->id) {
                $device = $this->devicesRepository->update(['user_id' => $user->id], $device->id);
            }
            return $device;
        }
        return null;
    }


}
