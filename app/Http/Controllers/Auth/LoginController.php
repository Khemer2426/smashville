<?php 

namespace App\Http\Controllers\Auth;

use App\Components\Services\IAuthenticationService;
use App\Exceptions\ProcessException;
use App\Components\Passive\Validators\AuthenticationValidator;
use App\Constants\Components\Roles;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    private $_authenticationService;
    
    public function __construct(
        IAuthenticationService $authenticationService
    )
    {
        $this->_authenticationService = $authenticationService;
    }

    public function loginForm()
    {
        return view('auth.login');    
    }

    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;
        $remember = $request->remember;

        $validator = AuthenticationValidator::validateLogin([
            'username' => $username,
            'password' => $password,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        try {
            
            $this->_authenticationService->authenticate(
                $username, 
                $password, 
                [Roles::ADMIN], 
                $remember
            );

        } catch (ProcessException $e) {
            return redirect()->back()->withInput()->withErrors([
                "message" => "Invalid login details."
            ]);
        }
        
        return redirect()->intended(route('dashboard'));
    }

    public function logout()
    {
        $this->_authenticationService->logout();

        return redirect()->route('login.form')->with('message', 'You are now logged out.');
    }
}