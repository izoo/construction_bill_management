<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
class LoginController extends Controller
{
    //
    use AuthenticatesUsers;
    /**
     * Where to redirect admins after login.
     * 
     * @var string
     */
    protected $redirectTo ='/admin';

    /**
     * 
     * Create a new controller insatance.
     * 
     * @return void
     * 
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
            $this->middleware('guest:admin')->except('logout');
            $this->middleware('guest:normal')->except('logoutUser');
        
    }
    /**
     * @return \Illuminate\Contracts\View\Factory\\Illuminate\View\View
     * 
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }
    public function showNormalForm()
    {
        return view('others.auth.login');
    }
    /**
     * @param Request $request
     * @return \Illuminate \Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     * 
     */
    

    public function login(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        if(Auth::guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ]))
        {
            return redirect()->intended(route('admin.dashboard'));
        }
        else
        {

            return back()->with('login_error' , 'Wrong Username or Password');
            
        }
        return back()->withInput($request->only('email','remember'));
    }
    
    public function normalLogin(Request $request)
    {
        $this->validate($request,[
            'user_email' => 'required',
            'password' => 'required|min:6'
        ]);
        if(Auth::guard('normal')->attempt([
            'user_email' => $request->user_email,
            'password' => $request->password
        ]))
        {
            return redirect()->intended(route('other.dashboard'));
        }
        else
        {

            return back()->with('login_error' , 'Wrong Username or Password');
            
        }

    }
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory\Illuminate\View
     */
    
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        return redirect()->route('admin.login');
    }
    public function logoutUser(Request $request)
    {
        Auth::guard('normal')->logout();
        $request->session()->invalidate();
        return redirect()->route('normal.login');
    }
}
