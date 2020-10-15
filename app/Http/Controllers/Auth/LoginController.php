<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
Use Alert;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticated(Request $request, $user)
    {
        Alert::success(trans('auth.login_successfully'));

        if ($user->role_id == config('setting.admin_id')) {
            return redirect()->route('admin.dashboard');
        }
        elseif ($user->role_id == config('setting.supplier_id')) {
            return redirect()->route('supplier.dashboard');
        }
        else {
            return redirect()->route('customer.home');
        }
    }
}
