<?php 

namespace App\Http\Controllers;

use App\Components\Passive\Validators\UserValidator;
use App\Components\Services\IUserService;
use App\Exceptions\ProcessException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    private $_userService;

    public function __construct(
        IUserService $userService
    ) {
        $this->_userService = $userService;
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $userVM = $this->_userService->getUserVM($user->id);

        return view('profile.index', compact('userVM'));
    }

    public function password(Request $request)
    {
        $user = Auth::user();

        try {
            $userVM = $this->_userService->getUserVM($user->id);
        } catch (ProcessException $e) {
            return redirect()->back()->withInput()->withErrors(['message' => $e->getMessage()]);
        }

        return view('profile.password', compact('userVM'));
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();

        $current_password = $request->current_password;
        $password = $request->password;
        $password_confirmation = $request->password_confirmation;
        
        $validator = UserValidator::validateChangePassword([
            'current_password' => $current_password,
            'password' => $password,
            'password_confirmation' => $password_confirmation
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        try {
            $this->_userService->changePassword(
                $user->id,
                $current_password,
                $password,
                $password_confirmation
            );
        } catch (ProcessException $e) {
            return redirect()->back()->withInput()->withErrors(['message' => $e->getMessage()]);
        }

        return redirect()->back()->with('message', 'Your password has been changed.');
    }

    public function generateTFA(Request $request)
    {
        $user = Auth::user();
        $tfa_password = $request->tfa_password;
        $tfa_password_confirmation = $request->tfa_password_confirmation;

        $validator = UserValidator::validateTFA([
            'tfa_password' => $tfa_password,
            'tfa_password_confirmation' => $tfa_password_confirmation
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withFragment('#security')->withInput()->withErrors($validator);
        }

        try { 
            $data = $this->_userService->checkUserAndGenerateQR($user->id, $tfa_password, $tfa_password_confirmation);
        } catch (ProcessException $e) {
            return redirect()->back()->withInput()->withErrors(['message' => $e->getMessage()]);
        }

        return view('auth.verify.2fa-qr', compact('data'));
    }
    
    public function enableTFA(Request $request, $secret_key)
    {
        $user = Auth::user();
        $code = $request->code;

        $validator = UserValidator::validateTFACode([
            'code' => $code
        ]);

        if ($validator->fails()) {
            return redirect()->route('profile')->withErrors($validator)->with('tfa_error', 'Something went wrong');
        }

        try { 
            $data = $this->_userService->enableTFA($user->id, $secret_key, $code);
        } catch (ProcessException $e) {
            return redirect()->route('profile')->withErrors(['tfa_message' => $e->getMessage()])->with('tfa_error', 'Something went wrong');
        }

        return redirect()->route('profile')->with('message', 'Two-factor authentication successfully enabled.');
    }

    public function disableTFA(Request $request)
    {
        $user = Auth::user();
        $tfa_password = $request->tfa_password;
        $tfa_password_confirmation = $request->tfa_password_confirmation;
        $verification_code = $request->verification_code;

        $validator = UserValidator::validateTFA([
            'tfa_password' => $tfa_password,
            'tfa_password_confirmation' => $tfa_password_confirmation,
            'verification_code' => $verification_code,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        try {
            $this->_userService->disableTFA($user->id, $tfa_password, $tfa_password_confirmation, $verification_code);
        } catch (ProcessException $e) {
            return redirect()->back()->withInput()->withErrors(['message' => $e->getMessage()]);
        }

        return redirect()->route('profile')->with('message', 'Your Two-Factor Authentication has been disabled.');
    }
}