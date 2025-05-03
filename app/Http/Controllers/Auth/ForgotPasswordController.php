<?php 

namespace App\Http\Controllers\Auth;

use App\Components\Services\IAuthenticationService;
use App\Components\Passive\Validators\AuthenticationValidator;
use App\Exceptions\ProcessException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    private $_authenticationService;

    public function __construct(
        IAuthenticationService $authenticationService
    )
    {
        $this->_authenticationService = $authenticationService;
    }
    
    public function forgotPasswordForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetEmailLink(Request $request)
    {
        $username = $request->username;

        $validator = AuthenticationValidator::validateUsername([
            "username" => $username,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        try {
            $this->_authenticationService->resetPasswordByUsername($username);
        } catch (ProcessException $e) {
            return redirect()->back()->withInput()->withErrors(['message' => $e->getMessage()]);
        }

        return redirect()->back()->with('message', 'The reset link has been sent to your email');
    }
}