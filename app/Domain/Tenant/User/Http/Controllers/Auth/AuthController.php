<?php

namespace App\Domain\Tenant\User\Http\Controllers\Auth;

;

use App\Common\Helpers\ActiveCompany;
use App\Domain\Tenant\Attendance\Entities\Device;
use App\Domain\Tenant\Attendance\Repositories\Contracts\DevicesRepository;
use App\Domain\Tenant\Employee\Entities\EmployeeDevices;
use App\Domain\Tenant\Employee\Repositories\Contracts\EmployeeDevicesRepository;
use App\Domain\Tenant\User\Entities\User;
use App\Domain\Tenant\User\Http\Requests\User\UserAPILoginFormRequest;
use App\Domain\Tenant\User\Http\Resources\User\UserResource;
use App\Domain\Tenant\User\Http\Services\RegisterAdminService;
use App\Domain\Tenant\User\Http\Services\RegisterDeviceService;
use App\Domain\Tenant\User\Repositories\Contracts\UserRepository;
use App\Domain\User\Services\RegisterEmployeeDeviceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use Joovlly\DDD\Traits\Responder;
use Joselfonseca\LighthouseGraphQLPassport\GraphQL\Mutations\Register;


class AuthController extends Controller
{
    use Responder,ActiveCompany;

    /**
     * @var UserRepository
     */
    protected UserRepository $userRepository;

    /**
     * @var RegisterDeviceService
     */
    protected RegisterDeviceService $registerDeviceService;

    /**
     * @var RegisterEmployeeDeviceService
     */
    protected RegisterEmployeeDeviceService $registerEmployeeDeviceService;


    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'user';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'users';

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'users';


    /**
     * @param UserRepository $userRepository
     * @param RegisterAdminService $registerDeviceService
     * @param RegisterEmployeeDeviceService $registerEmployeeDeviceService
     */
    public function __construct(UserRepository $userRepository, RegisterDeviceService $registerDeviceService, RegisterEmployeeDeviceService $registerEmployeeDeviceService)
    {
        $this->userRepository = $userRepository;
        $this->registerDeviceService = $registerDeviceService;
        $this->registerEmployeeDeviceService = $registerEmployeeDeviceService;
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(UserAPILoginFormRequest $request)
    {
        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials))
            return response()->json(['message' => 'Invalid email or password.'], 422);
        if ($this->isActiveCompany())
            return response()->json(['message' => 'The system is deactivated currently please contact joovlly.'], 403);

        $user = $request->user();

        if (!$user->hasRole('register-attendance-qr') && $request->type == "admin")
            return response()->json(['message' => 'Dose not have the right permissions.'], 422);

        $device = $this->checkForDevice($user,request(['type', 'firebase_token','platform']));

        return $this->createToken($user, 'logged in successfully', 200, $device);
    }

    /**
     * create Token
     *
     * @param User $user
     * @param string $message
     * @param int $status_code
     * @param $device
     * @return \Illuminate\Http\JsonResponse [string] expires_at
     */
    public function createToken(User $user, $message = "", $status_code = 200, $device = null)
    {
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addMonths(2);
        $token->save();
        return response()->json(['status' => 'success', 'message' => $message, 'access_token' => $tokenResult->accessToken, 'user' =>new UserResource($user), 'token_type' => 'Bearer', 'device' => $device, 'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
        ], $status_code);
    }

    /**
     * @param User $user
     * @param array $data
     * @return Device|EmployeeDevices
     */
    public function checkForDevice(User $user, array $data)
    {
        if ($data['type'] == "admin")
            $device = $this->registerDeviceService->register($user, $data['firebase_token'], $data['platform']);
        else
            $device = $this->registerEmployeeDeviceService->register($user, $data['firebase_token'],  $data['platform']);

        return $device;
    }


    /**
     * Logout user (Revoke the token)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Successfully logged out']);
    }

}
