<?php

namespace App\Domain\Admin\Http\Controllers\Auth;

use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
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


    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view("{$this->domainAlias}::{$this->viewPath}.auth.login", [
            'title' => __('main.login')
        ]);
    }

    /**
     * @Override
     *
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated()
    {
        if (auth('staff')->check()) {
            return redirect()->intended(route('dashboard'));
        }
        return redirect()->intended($this->redirectPath());
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('staff');
    }
}
