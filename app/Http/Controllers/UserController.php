<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Cart;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    function index()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route(__('routes.profile'));
        } else {
            $data['breadcrumbs'][] = Array('url'=>route(__('routes.login')),'title'=>__('login'));
            $data['page']          = (object)Array('name'=>__('login'));
            return view('users.login',$data);
        }
    }

    function register(){
        $data['page'] = (object)Array('name'=>__('register'));
        return view('users.register',$data);
    }

    function save(Request $request){

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:5',
        ]);

        Auth::login($user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'lang'     => app()->getLocale(),
        ]));

        event(new Registered($user));

        alert('success',__('msg_register_success'));

        if(\Cart::isEmpty())
            return redirect()->route(__('routes.profile'));
        else
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
 
        if (Auth::attempt($credentials, $remember))
        {
            $request->session()->regenerate();
 
            if(\Cart::isEmpty())
                return redirect()->route(__('routes.login'));
            else
                return redirect()->back();
        } else {
            $login_attempts = !empty(session('login_attempts')) ? session('login_attempts') : 1;
            session()->put('login_attempts', $login_attempts+1);
            session()->put('wait_time',5*$login_attempts);
            alert('danger',__('login_attempts',['seconds'=>session('wait_time')]));

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
        Auth::logout();
        
        \Cart::clear();
        
        \Cart::clearCartConditions();
        
        $request->session()->invalidate();
 
        $request->session()->regenerateToken();

        alert('success',__('logged_out'));
        
        return redirect()->route(__('routes.login'));
    }

    function profile(Request $request)
    {
        if ($request->has(['name', 'email']))
        {
            $user = Auth::user();

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
            
            $user->update($input);

            if($user->wasChanged())
                alert('success',__('msg_update_success'));
            else
                alert('info',__('msg_update_error'));

            return redirect()->route(__('routes.profile'));
        }

        if (Auth::guard('web')->check())
        {
            $data['page'] = (object)Array('name'=>__('my_profile'));
            $data['user'] = Auth::user();
            $data['orders'] = Order::whereUser_id(Auth::user()->id)->with('statuses')->get();
            return view('users.profile', $data);
        }
        else
        {
            $notification = [
                'message' => __('login_needed'),
                'alert-type' => 'success'
            ];
            return redirect()->route(__('routes.login'))->with($notification);
        }

    }

    function ForgotPassword()
    {
        $data['page'] = (object)Array('name'=>__('forgot_password'));
        return view('users.forgot-password',$data);
    }

    function ForgotPassword_send(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
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

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $status == Password::PASSWORD_RESET
                    ? redirect()->route(__('routes.login'))->with('message', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
    }

    public function fetchState(Request $request)
    {
        return response()->json(User::getStates($request->country));
    }

    public function fetchCity(Request $request)
    {
        return response()->json(User::getCities($request->state));
    }

     /**
     * Get the user's preferred locale.
     *
     * @return string
     */
    public function preferredLocale()
    {
        return $this->locale;
    }
}
