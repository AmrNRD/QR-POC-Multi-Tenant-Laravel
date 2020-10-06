<?php

namespace App\Domain\Tenant\User\Http\Controllers\Auth;

use App\Domain\Tenant\User\Http\Requests\User\UserForgetPasswordFormRequest;
use App\Domain\Tenant\User\Repositories\Contracts\UserRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Joovlly\DDD\Traits\Responder;


class ForgetPasswordController extends Controller
{
    use Responder;
    /**
     * @var mixed
     */
    private $userRepository, $reminders;

    /**
     * View Path.
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

    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    //use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @param UserRepository $userRepository
     * @param PasswordResetRepository $reminders
     */
    public function __construct(UserRepository $userRepository, PasswordResetRepository $reminders)
    {
        $this->userRepository = $userRepository;
        $this->reminders = $reminders;
    }

    public function __invoke(UserForgetPasswordFormRequest $request)
    {
        $user = $this->userRepository->whereEmail($request->validated())->firstOrFail();

        Mail::to($user)->send(
            new ResetPassword(
                $user,
                $this->reminders->hasOrCreateToken($user)
            )
        );

        $this->setApiResponse(fn () => response()->json(['message'=>'done'], 200));

        return $this->response();
    }
}
