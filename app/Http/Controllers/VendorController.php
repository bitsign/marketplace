<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Subscription;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function loginRegister()
    {
        if (Auth::guard('vendor')->check()) {
            return redirect()->route(__('vendor.profile'));
        } else {
            $data['breadcrumbs'][] = Array('url'=>route(__('routes.login')),'title'=>__('login'));
            $data['page']          = (object)Array('name'=>__('login'));
            return view('vendors.login-register',$data);
        }
    }

    function save(Request $request){

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:vendors',
            'password' => 'required|string|min:5',
        ]);

        Auth::guard('vendor')->login($vendor = Vendor::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'lang'     => app()->getLocale(),
        ]));

        event(new Registered($vendor));

        alert('success',__('msg_register_success'));

        return redirect()->back();
    }

    /**
     * Handle an incoming authentication request.
     * @throws ValidationException
     */
    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials['active'] = 1;

        $remember = $request->remember !== NULL ? true : false;
 
        if (Auth::guard('vendor')->attempt($credentials, $remember))
        {
            $request->session()->regenerate();
            return redirect()->route('vendor.profile');
        } 
        else
        {
            alert('danger',__('auth.failed'));
            return redirect()->back();
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('vendor')->logout();
        
        $request->session()->invalidate();
 
        $request->session()->regenerateToken();

        alert('success',__('logged_out'));
        
        return redirect()->route('vendor.login-register');
    }

    function profile(Request $request)
    {
        if ($request->has(['name', 'email']))
        {
            $vendor = Auth::guard('vendor')->user();

            $request->validate([
                'name'  => 'required|string|max:50',
                'email' => 'required|string|email|max:50',
            ]);
            $input = $request->all();

            if(!empty($request->password) && !empty($request->confirm_password))
                $input['password'] = Hash::make($request->password);
            else
                unset($input['password']);

            unset($input['_method']);
            unset($input['_token']);
            unset($input['confirm_password']);
            
            $vendor->update($input);

            if($vendor->wasChanged())
                alert('success',__('msg_update_success'));
            else
                alert('info',__('msg_update_error'));

            return redirect()->route('vendor.profile');
        }

        if (Auth::guard('vendor')->check())
        {
            $data['page'] = (object)Array('name'=>__('my_profile'));
            $data['vendor'] = Auth::guard('vendor')->user();
            $data['products'] = array();
            $data['subscription'] = Subscription::whereVendor_id($data['vendor']->id)->first();
            if($data['subscription']!==NULL)
                $data['package'] = Package::whereStripe_plan($data['subscription']['stripe_price'])->first();
            else
                $this->data['package'] = array();
            return view('vendors.profile', $data);
        }
        else
        {
            alert('danger',__('login_needed'));
            return redirect()->route('vendor.login-register');
        }

    }

    function forgotPassword()
    {
        $data['page'] = (object)Array('name'=>__('forgot_password'));
        return view('vendors.forgot-password',$data);
    }

    function forgotPasswordSend(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::broker('vendors')->sendResetLink(
            $request->only('email')
        );

        if($status == Password::RESET_LINK_SENT)
            alert('success',__($status));
        else
            alert('danger',__($status));
        return back();
    }

    /**
     * Handle an incoming new password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeNewPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the vendor's password. If it is successful we
        // will update the password on an actual vendor model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::broker('vendors')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($vendor) use ($request) {
                $vendor->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($vendor));
            }
        );

        // If the password was successfully reset, we will redirect the vendor back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('vendor.login-register')->with('message', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
    }

    public function fetchState(Request $request)
    {
        return response()->json(Vendor::getStates($request->country));
    }

    public function fetchCity(Request $request)
    {
        return response()->json(Vendor::getCities($request->state));
    }

    public function sales()
    {
        $data['sales'] = array();
        $data['page'] = (object)Array('name'=>__('sales'));
        return view('vendors.sales',$data);
    }

    public function addProduct()
    {
        $data['sales'] = array();
        $data['page'] = (object)Array('name'=>__('add_product'));
        return view('vendors.add-product',$data);
    }

     /**
     * Get the vendor's preferred locale.
     *
     * @return string
     */
    public function preferredLocale()
    {
        return $this->locale;
    }
}
