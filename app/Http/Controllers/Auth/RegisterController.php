<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Alert;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'email', 'max:50', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => config('setting.active_id'),
        ]);
    }

    protected function registered(Request $request, $user)
    {
        Alert::success(trans('auth.register_successfully'));

        if ($user->role_id == config('setting.supplier_id')) {
            return redirect()->route('supplier.dashboard');
        }
        else {
            return redirect()->route('customer.home');
        }
    }
}
