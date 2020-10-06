<?php

namespace App\Domain\Tenant\User\Http\Controllers\Auth;

use App\Domain\Tenant\User\Http\Resources\User\UserResource;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;

class ResetPasswordController extends Controller
{
    /**
     * @var mixed
     */
    protected $reminders;

    /**
     * @param PasswordResetRepository $passwordReset
     */
    public function __construct(PasswordResetRepository $passwordReset)
    {
        $this->passwordReset = $passwordReset;
    }

    /**
     * @param User $user
     * @param null $token
     * @param nullResetUserPasswordFormRequest $request
     * @return UserResource|\Illuminate\Http\JsonResponse
     */
    public function __invoke(User $user, $token, ResetUserPasswordFormRequest $request)
    {
        if ($this->passwordReset->complete($user, $token)) {
            $user->update($request->validated());

            return new UserResource($user);
        }

        return response()->json(['message' => 'invalid token',], 400);
    }
}
