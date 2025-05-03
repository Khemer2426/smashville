<?php 

namespace App\Http\Controllers\Auth;

use App\Components\Services\IAuthenticationService;
use App\Exceptions\ProcessException;
use App\Components\Passive\Validators\AuthenticationValidator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ResetPasswordController extends Controller
{
    private $_authenticationService;

    public function __construct(
        IAuthenticationService $authenticationService
    )
    {
        $this->_authenticationService = $authenticationService;
    }
    
    public function resetPasswordForm($code)
    {
        return view('auth.passwords.reset', compact('code'));
    }

    public function passwordReset(Request $request)
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
            $data = $this->_authenticationService->passwordReset($code, $password, $password_confirmation);
            Session::put('qr_code', $data);
        } catch (ProcessException $e) {
            return redirect()->back()->withInput()->withErrors(['message' => $e->getMessage()]);
        }

        return redirect()->route('user.password.reset.tfa', $code);
    }

    public function tfaDetails(Request $request, $code)
    {
        $data = Session::get('qr_code');

        return view('auth.passwords.2fa-qr', compact('data', 'code'));
    }
}