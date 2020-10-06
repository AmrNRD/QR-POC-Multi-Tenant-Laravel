<?php

namespace App\Domain\Tenant\Attendance\Services;

use App\Domain\Tenant\Attendance\Entities\Attendance;
use App\Domain\Tenant\Attendance\Repositories\Contracts\AttendanceRepository;
use App\Domain\Tenant\Attendance\Repositories\Contracts\DevicesRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;


/**
 * Class RegisterAttendanceService.
 *
 * @package namespace App\Domain\Tenant\Attendance\Services;
 */
class AttendanceService
{

    /**
     * Holds Attendance Repository Instance
     *
     * @var AttendanceRepository
     */
    public AttendanceRepository $attendanceRepository;


    /**
     * Holds Devices Repository Instance
     *
     * @var DevicesRepository
     */
    public DevicesRepository $devicesRepository;


    public function __construct(AttendanceRepository $attendanceRepository, DevicesRepository $devicesRepository)
    {
        $this->attendanceRepository = $attendanceRepository;
        $this->devicesRepository = $devicesRepository;
    }

    /**
     * Create new Attendance or update last one
     *
     *
     * @param array $data
     */
    public function create(array $data)
    {
       $device= $this->devicesRepository->findWhere(['qr_code'=>$data['qr_code']])->first();
       if(!$device){
           return  response()->json(['message'=>'invalid code'],422);
       }else{

       }
    }

}
