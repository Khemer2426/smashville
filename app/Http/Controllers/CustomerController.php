<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Constants\Components\Roles;
use App\Exceptions\ProcessException;
use App\Components\Services\IUserService;
use App\Components\Services\ICustomerService;
use App\Components\Passive\Validators\UserValidator;
use App\Components\Services\IRolesPermissionsService;

class CustomerController extends Controller
{
    private $_customerService;
    private $_rolesPermissionsService;
    private $_userService;

    public function __construct(
        ICustomerService $customerService,
        IRolesPermissionsService $rolesPermissionsService,
        IUserService $userService,
    )
    {
        $this->_customerService = $customerService;
        $this->_rolesPermissionsService = $rolesPermissionsService;
        $this->_userService = $userService;
    }

    public function index(Request $request)
    {
        // if ($request->ajax()) {
        //     $keyword = $request->search['value'];
        //     return $this->_userService->getUsersDatatable($keyword);
        // }

        $roles = $this->_rolesPermissionsService->getRoles();
        // $schools = $this->_schoolService->getAll();

        return view('admin.customer.index', compact('roles'));
    }

    public function indexComments(Request $request)
    {
        return view('admin.customer.comments');
    }
    
    public function store(Request $request)
    {
        $username = $request->username;
        $password = $request->password;
        $password_confirmation = $request->password_confirmation;
        $full_name = $request->full_name;
        $role = $request->role;
        $active = $request->active;

        $validator = UserValidator::validateCreateUser([
            'username' => $username,
            'password' => $password,
            'password_confirmation' => $password_confirmation,
            'full_name' => $full_name,
            'role' => $role,
            'active' => $active
        ]);

        // if ($validator->fails()) {

        //     return response()->json(['errors' => $validator->errors()], 422);
        // }
        
        try {

            $user = $this->_userService->createNewUser(
                $username, 
                $password, 
                $full_name, 
                $role, 
                $active
            );

        } catch (ProcessException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
        
        return response()->json($user, 200);
    }

}