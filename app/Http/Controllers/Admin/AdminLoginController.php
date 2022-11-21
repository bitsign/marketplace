<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AdminBaseController;

class AdminLoginController extends AdminBaseController
{

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        //dd(session());
        return view('admin.login.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $user = Auth::guard('admin')->user();
            session()->put('AdminUser',$user);
            return redirect()->to('admin/orders');
        } else {
            session()->put('most_recent_activity',time());
            $login_attempts = !empty(session('admin_login_attempts')) ? session('admin_login_attempts') : 1;
            session()->put('admin_login_attempts', $login_attempts+1);
            session()->put('admin_wait_time',5*$login_attempts);
            alert('danger',__('admin_login_attempts',['seconds'=>session('admin_wait_time')]));
            return redirect()->back();
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        
        $request->session()->invalidate();
        
        $request->session()->regenerateToken();
        
        alert('success',__('logged_out'));
        
        return redirect()->to('admin/login');
    }
}
