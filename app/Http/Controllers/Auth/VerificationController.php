<?php 

namespace App\Http\Controllers\Auth;

use App\Components\Services\IAuthenticationService;
use App\Components\Passive\Validators\AuthenticationValidator;
use App\Exceptions\ProcessException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class VerificationController extends Controller
{
    private $_authenticationService;

    public function __construct(
        IAuthenticationService $authenticationService
    )
    {
        $this->_authenticationService = $authenticationService;
    }

    public function index()
    {
        return view('auth.verify.verify');   
    }

    public function resend(Request $request)
    {
        $username = $request->query('username');

        $validator = AuthenticationValidator::validateUsername([
            "username" => $username,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        try {
            $this->_authenticationService->resendRegistrationEmailByUsername($username);
        } catch (ProcessException $e) {
            return redirect()->back()->withInput()->withErrors(['message' => $e->getMessage()]);
        }

        return redirect()->back()->with('message', 'The reset link has been sent to your email');
    }

    public function verify($code)
    {
        $validator = AuthenticationValidator::validateCode([
            "code" => $code,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        try {
            $data = $this->_authenticationService->verifyAndActivateUser($code);
            Session::put('qr_code', $data);
        } catch (ProcessException $e) {
            throw $e;
        }

        if (config('google2fa.enabled')) {

            return redirect()->route('user.verify.tfa', $code);
        }

        return redirect()->route('user.login.form')->with('message', 'Your account has been verified successfully.');
    }

    public function tfaDetails(Request $request, $code)
    {
        $data = Session::get('qr_code');

        return view('auth.verify.2fa-qr', compact('data','code'));
    }

    public function verifyAndSetPasswordForm($code)
    {
        return view('auth.verify.set', compact('code'));  
    }

    public function verifyAndSetPassword(Request $request)
    {
        $code = $request->code;
        $password = $request->password;
        $password_confirmation = $request->password_confirmation;

        $validator = AuthenticationValidator::validateResetPassword([
            'code' => $code,
            'password' => $password,
            'password_confirmation' => $password_confirmation
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        try {
            $data = $this->_authenticationService->verifyAndSetPassword($code, $password, $password_confirmation);
            Session::put('qr_code', $data);
        } catch (ProcessException $e) {
            return redirect()->back()->withInput()->withErrors(['message' => $e->getMessage()]);
        }

        if (config('google2fa.enabled')) {

            return redirect()->route('user.verify.tfa', $code);
        }

        return redirect()->route('user.login.form')->with('message', 'Your account has been verified successfully.');
    }
}