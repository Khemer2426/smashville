<?php

namespace App\Http\Controllers\Auth;

use App\Components\Services\IAuthenticationService;
use App\Components\Passive\Validators\AuthenticationValidator;
use App\Constants\Components\Roles;
use App\Exceptions\ProcessException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    private $_authenticationService;

    public function __construct(
        IAuthenticationService $authenticationService
    )
    {
        $this->_authenticationService = $authenticationService;
    }

    public function registerForm()
    {
        return view('auth.register');   
    }

    public function register(Request $request)
    {
        $username = $request->username;
        $password = $request->password;
        $password_confirmation = $request->password_confirmation;
        $company = $request->company;

        $validator = AuthenticationValidator::validateRegister([
            'company' => $company,
            'username' => $username,
            'password' => $password,
            'password_confirmation' => $password_confirmation
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        try {
            $this->_authenticationService->register(
                $company,
                $username, 
                $password, 
                $password_confirmation,
                Roles::CUSTOMER
            );
        } catch (ProcessException $e) {
            return redirect()->back()->withInput()->withErrors(['message' => $e->getMessage()]);
        }

        return redirect()->route('user.verify.page', ['username' => $username]);
    }
}