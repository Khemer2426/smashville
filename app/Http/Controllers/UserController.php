<?php

namespace App\Http\Controllers;

use App\Components\Passive\Validators\UserValidator;
use App\Components\Services\IUserService;
use App\Components\Services\IRolesPermissionsService;
// use App\Components\Services\ISchoolService;
use App\Constants\Components\Roles;
use App\Exceptions\ProcessException;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $_userService;
    private $_rolesPermissionsService;
    // private $_schoolService;

    public function __construct(
        IUserService $userService,
        IRolesPermissionsService $rolesPermissionsService,
        // ISchoolService $schoolService
    )
    {
        $this->_userService = $userService;
        $this->_rolesPermissionsService = $rolesPermissionsService;
        // $this->_schoolService = $schoolService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $keyword = $request->search['value'];
            return $this->_userService->getUsersDatatable($keyword);
        }

        $roles = $this->_rolesPermissionsService->getRoles();
        // $schools = $this->_schoolService->getAll();

        return view('users.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $username = $request->username;
        $password = $request->password;
        $password_confirmation = $request->password_confirmation;
        $full_name = $request->full_name;
        $role = $request->role;
        $school = $request->school;
        $active = $request->active;

        $validator = UserValidator::validateCreateUser([
            'username' => $username,
            'password' => $password,
            'password_confirmation' => $password_confirmation,
            'full_name' => $full_name,
            'role' => $role,
            'school' => $school,
            'active' => $active
        ]);

        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        try {

            $user = $this->_userService->createNewUser(
                $username, 
                $password, 
                $full_name, 
                $role, 
                $school, 
                $active
            );

        } catch (ProcessException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
        
        return response()->json($user, 200);
    }

    public function unlock($id)
    {
        $validator = UserValidator::validateUserId([
            'user_id' => $id,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $this->_userService->unlockUser($id);
        } catch (ProcessException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
        
        return response()->json('success', 200);
    }

    public function edit($id)
    {
        $userVM = $this->_userService->getUserVM($id);

        $roles = $this->_rolesPermissionsService->getRoles();

        // $schools = $this->_schoolService->getAll();

        return view('users.edit', compact('userVM', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $password = $request->password;
        $password_confirmation = $request->password_confirmation;
        $full_name = $request->full_name;
        $role = $request->role;
        $school = $request->school;
        $active = $request->active;

        $validator = UserValidator::validateUpdateUser([
            'user_id' => $id,
            'password' => $password,
            'password_confirmation' => $password_confirmation,
            'full_name' => $full_name,
            'role' => $role,
            'school' => $school,
            'active' => $active
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $user = $this->_userService->updateUser(
                $id,
                $full_name, 
                $role, 
                $school, 
                $active,
                $password
            );

        } catch (ProcessException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }

        return response()->json($user, 200);
    }

    public function destroy($id)
    {
        $validator = UserValidator::validateUserId([
            'user_id' => $id,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $this->_userService->deleteUser($id);
        } catch (ProcessException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }

        return response()->json('success', 200);
    }

    public function assignSchoolForm($id)
    {
        $userVM = $this->_userService->getUserVM($id);

        // $schools = $this->_schoolService->getAll();

        if (!in_array(Roles::MULTISCHOOL, $userVM->roles)) {

            return redirect()->route('admin.users');
        }

        return view('users.assign-school', compact('userVM'));
    }

    public function assignSchool(Request $request, $id)
    {
        $school_id = $request->school;

        $validator = UserValidator::validateUserIdAndSchoolId([
            'user_id' => $id,
            'school_id' => $school_id
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        try {
            $access = $this->_userService->assignSchool(
                $id, 
                $school_id
            );

        } catch (ProcessException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
        
        return response()->json($access, 200);
    }

    public function deleteAssignSchool($id, $school_id)
    {
        $validator = UserValidator::validateDeleteAssignSchool([
            'user_id' => $id,
            'school_id' => $school_id
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $this->_userService->deleteAssignSchool($id, $school_id);
        } catch (ProcessException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }

        return response()->json('success', 200);
    }
}