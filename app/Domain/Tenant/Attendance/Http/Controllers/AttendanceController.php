<?php

namespace App\Domain\Tenant\Attendance\Http\Controllers;

use App\Common\Criteria\AuthCriteria;
use App\Common\Criteria\AuthEmployeeCriteria;
use App\Domain\Tenant\Attendance\Http\Resources\Devices\DevicesResource;
use App\Domain\Tenant\Attendance\Repositories\Contracts\DevicesRepository;
use App\Domain\Tenant\Employee\Entities\Employee;
use App\Domain\Tenant\Employee\Http\Resources\Employee\EmployeeResource;
use App\Domain\Tenant\Employee\Repositories\Contracts\EmployeeRepository;
use App\Domain\Tenant\Employee\Repositories\Contracts\EmployeeShiftRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use App\Domain\Tenant\Attendance\Http\Requests\Attendance\AttendanceStoreFormRequest;
use App\Domain\Tenant\Attendance\Http\Requests\Attendance\AttendanceUpdateFormRequest;
use App\Domain\Tenant\Attendance\Repositories\Contracts\AttendanceRepository;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Tenant\Attendance\Entities\Attendance;
use App\Domain\Tenant\Attendance\Http\Resources\Attendance\AttendanceResourceCollection;
use App\Domain\Tenant\Attendance\Http\Resources\Attendance\AttendanceResource;

class AttendanceController extends Controller
{
    use Responder,\SendPushNotification;

    protected AttendanceRepository $attendanceRepository;

    protected DevicesRepository $deviceRepository;

    protected EmployeeRepository $employeeRepository;

    protected EmployeeShiftRepository $employeeShiftRepository;

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'attendance';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'attendances';

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'attendances';


    /**
     * @param AttendanceRepository $attendanceRepository
     * @param EmployeeRepository $employeeRepository
     * @param EmployeeShiftRepository $employeeShiftRepository
     * @param DevicesRepository $devicesRepository
     */
    public function __construct(AttendanceRepository $attendanceRepository,EmployeeRepository $employeeRepository,EmployeeShiftRepository $employeeShiftRepository,DevicesRepository $devicesRepository)
    {
        $this->attendanceRepository = $attendanceRepository;
        $this->employeeRepository=$employeeRepository;
        $this->employeeShiftRepository=$employeeShiftRepository;
        $this->deviceRepository=$devicesRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $index = $this->attendanceRepository->spatie()->all();

        $this->setData('title', __('main.show-all') . ' ' . __('main.attendance'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        $this->useCollection(AttendanceResourceCollection::class, 'data');

        return $this->response();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setData('title', __('main.add') . ' ' . __('main.attendance'), 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $this->addView("{$this->domainAlias}::{$this->viewPath}.create");

        $this->setApiResponse(fn() => response()->json(['create_your_own_form' => true]));

        return $this->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AttendanceStoreFormRequest $request)
    {
        $store = $this->attendanceRepository->create($request->validated());

        if($store){
            $this->setData('data', $store);

            $this->redirectRoute("{$this->resourceRoute}.show",[$store->id]);
            $this->useCollection(AttendanceResource($store), 'data');
        }else{
            $this->redirectBack();
            $this->setApiResponse(fn()=> response()->json(['created'=>false]));
        }

        return $this->response();

    }

    public  function  registerAttendanceViaQR(Request $request){
        $qr_code=$request->qr_code;
        $device = $this->deviceRepository->findWhere(['qr_code' => $qr_code])->first();
        if($device){
            $updated_device=$this->deviceRepository->update(['qr_code'=>Str::random(15)],$device->id);
            $this->sendNotificationToAdmin("QR Code used",[$device->firebase_token],["device"=>new DevicesResource($updated_device)]);
            $user = Auth::user();
            if ($user->employee) {
                $attendance = $this->attendanceRepository->orderBy('date')->findWhere(['employee_id' => $user->employee->id])->last();
                if($attendance) {
                    if ($attendance->status === "checked_in") {
                        return $this->checkoutUser($attendance);
                    } else {
                        if ($attendance->date != Carbon::now()->toDateString()) {
                            return $this->checkInEmployee($user->employee);
                        } else {
                            $this->setApiResponse(fn() => response()->json(['message' => "You Already checkout today"], 422));
                            $this->redirectRoute("{$this->resourceRoute}.index");
                            return $this->response();
                        }
                    }
                }else{
                    return $this->checkInEmployee($user->employee);
                }
            } else {
                $this->setApiResponse(fn() => response()->json(['message' => "Invalid Try, Not Employee"],422));
                $this->redirectRoute("{$this->resourceRoute}.index");
                return $this->response();
            }
        }else{
            $this->setApiResponse(fn() => response()->json(['message' => "Invalid Code, Please Try Again"],422));
            $this->redirectRoute("{$this->resourceRoute}.index");
            return $this->response();
        }

    }


    public function checkoutUser(Attendance $attendance)
    {
        $check_in = Carbon::parse($attendance->date . ' ' . $attendance->check_in);
        $minutes_from_check_in = $check_in->diffInMinutes(Carbon::now());
        $shift=$attendance->employeeShift->shift;
        $buffer=$shift->threshold;
        $shift_start=Carbon::parse(Carbon::now()->toDateString().' '.$shift->start_at);
        $shift_end=Carbon::parse(Carbon::now()->toDateString().' '.$shift->end_at);
        $shift_hours=$shift_start->diffInMinutes($shift_end);
        if($minutes_from_check_in>=($shift_hours-(int) $buffer))
        {
            $updated_attendance=$this->attendanceRepository->update(["status"=>"checked_out","check_out"=>Carbon::now()->toTimeString()],$attendance->id);
            $this->setApiResponse(fn() => response()->json(['message' => "Checked out successfully","attendance"=>new AttendanceResource($updated_attendance)]));
            $this->redirectRoute("{$this->resourceRoute}.index");
            return $this->response();
        }else
        {
            $updated_attendance=$this->attendanceRepository->update(["status"=>"work_hours_not_completed","check_out"=>Carbon::now()->toTimeString()],$attendance->id);
            $this->setApiResponse(fn() => response()->json(['message' => "Checked out successfully, Work hours not completed ","attendance"=>new AttendanceResource($updated_attendance)]));
            $this->redirectRoute("{$this->resourceRoute}.index");
            return $this->response();
        }
    }

    public function checkInEmployee(Employee $employee)
    {
        $user_shift=$this->employeeShiftRepository->scopeQuery(function($query){
            return $query->where('to','>',Carbon::now()->toDateString())->orWhereNull('to');
        })->findWhere(['employee_id'=>$employee->id,['from','<',Carbon::now()->toDateString()]])->last();
       if($user_shift)
       {
           $shift=$user_shift->shift;
           $store = $this->attendanceRepository->create(['status'=>"checked_in",'date'=>Carbon::now()->toDateString(),'check_in'=>Carbon::now()->toTimeString(),'shift_start'=>$shift->start_at,'shift_end'=>$shift->end_at,'employee_id'=>$employee->id,'employee_shift_id'=>$user_shift->id]);
           if ($store) {
               $this->redirectRoute("{$this->resourceRoute}.index");
               $this->setApiResponse(fn() => response()->json(['message' => "Checked in successfully","attendance"=>new AttendanceResource($store)]));
               return $this->response();
           }
       }else{
           $this->setApiResponse(fn() => response()->json(['message' => "User doesn't have a valid shift"],422));
           $this->redirectRoute("{$this->resourceRoute}.index");
           return $this->response();
       }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        $this->setData('title', __('main.show') . ' ' . __('main.attendance') . ' : ' . $attendance->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $this->setData('show', $attendance);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.show");

        $this->useCollection(AttendanceResource::class, 'show');

        return $this->response();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function monthAttendanceRecords()
    {

        $this->attendanceRepository->pushCriteria(new AuthEmployeeCriteria());
        $start_of_the_month_date=new Carbon('first day of this month');
        $end_of_the_month_date= new Carbon('last day of this month');
        $day_of_the_month_date=Carbon::now();
        $index = $this->attendanceRepository->findWhereBetween('date', [$start_of_the_month_date,$end_of_the_month_date]);

        $work_days_until_now=$day_of_the_month_date->diffInWeekdays($start_of_the_month_date);

        $number_of_checked_out_days=$index->where('status','checked_out')->count();
        $number_of_work_hours_not_completed_days=$index->where('status','work_hours_not_completed')->count();
        $number_of_missed_days=$index->whereIn('status',['missed_check_in','missed_check_in_but_checked_out'])->count();
        $number_of_absented_days=$work_days_until_now-$index->count()-1;

        $this->setData('title', __('main.show-all') . ' ' . __('main.attendance'));

        $this->setData('alias', $this->domainAlias);

        $this->setData('data', $index);

       $this->setApiResponse(fn() => response()->json(["attendances"=>AttendanceResource::collection($index),'number_of_checked_out_days'=>$number_of_checked_out_days,'number_of_work_hours_not_completed_days'=>$number_of_work_hours_not_completed_days,'number_of_missed_days'=>$number_of_missed_days,'number_of_absented_days'=>$number_of_absented_days]));

        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");

        return $this->response();
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        $this->setData('title', __('main.edit') . ' ' . __('main.attendance') . ' : ' . $attendance->id, 'web');

        $this->setData('alias', $this->domainAlias, 'web');

        $this->setData('edit', $attendance);

        $this->addView("{$this->domainAlias}::{$this->viewPath}.edit");

        $this->useCollection(AttendanceResource::class, 'edit');

        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AttendanceUpdateFormRequest $request, $attendance)
    {
        $update = $this->attendanceRepository->update($request->validated(), $attendance);

        if ($update) {
            $this->redirectRoute("{$this->resourceRoute}.show", [$update->id]);
            $this->setData('data', $update);
            $this->useCollection(AttendanceResource::class, 'data');
        } else {
            $this->redirectBack();
            $this->setApiResponse(fn() => response()->json(['updated' => false], 422));
        }

        return $this->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ids = request()->get('ids', [$id]);

        $delete = $this->attendanceRepository->destroy($ids);

        if ($delete) {
            $this->redirectRoute("{$this->resourceRoute}.index");
            $this->setApiResponse(fn() => response()->json(['deleted' => true], 200));
        } else {
            $this->redirectBack();
            $this->setApiResponse(fn() => response()->json(['updated' => false], 422));
        }

        return $this->response();
    }

}
