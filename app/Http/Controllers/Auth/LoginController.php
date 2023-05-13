<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticated(Request $request, $user)
    {
        if ($user->role == 'admin') {
            $url = route('admin.dashboard');
        } elseif($user->role == 'project-manager'){
            $url = route('project-manager.dashboard');
        } elseif($user->role == 'subcontractor'){
            $url = route('subcontractor.dashboard');
        } elseif($user->role == 'manager'){
            $url = route('manager.dashboard');
        }elseif($user->role == 'main-manager'){
            $url = route('main-manager.dashboard');
        } else {
            Auth::logout();
            session()->flash('message', 'Invalid Credentials!');
            session()->flash('alert-class', 'alert-danger');

            return redirect('/login');
        }

        if (!is_null(session('redirectUrl'))) {
            $url = session('redirectUrl');
            session()->forget('redirectUrl');
        }

        return redirect($url);
    }
}
