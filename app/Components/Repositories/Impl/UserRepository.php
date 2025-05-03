<?php

namespace App\Components\Repositories\Impl;

use App\Components\Repositories\IUserRepository;
use App\Constants\Components\Roles;
use App\Models\Entities\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserRepository implements IUserRepository
{
    public function createUser(
        $username, 
        $password, 
        $full_name, 
        $role_name, 
        // $school_id, 
        $active
    )
    {
        return User::create([
            'username' => $username,
            'password' => $password,
            'user_fullname' => $full_name,
            'user_jobrole' => $role_name,
            // 'user_school' => $school_id,
            'user_fail' => 0,
            'user_active' => !empty($active) ? 'YES' : 'NO',
            'active' => $active
        ]);
    }

    public function deactivateUser($user_id)
    {
        return User::where('id', $user_id)->update(['active' => false]);
    }

    public function activateUser($user_id)
    {
        return User::where('id', $user_id)->update(['active' => true]);
    }

    public function setUserPassword($user_id, $password)
    {
        return User::where('id', $user_id)->update(['password' => $password]);
    }

    public function getUser($user_id)
    {
        return User::where('id', $user_id)->first();
    }

    public function getUserByUsername($username)
    {
        return User::where('username', $username)->first();
    }
    
    public function getUsersDatatable($keyword = null)
    {
        $keyword = trim($keyword);
        $users = User::leftJoin('tb_user.user_school')
        ->select([
            'tb_user.id',
            'tb_user.username',
            'tb_user.user_fullname',
            'tb_user.user_jobrole',
            'tb_user.active'
        ]);

        $datatables = datatables()::of($users);
        
        $datatables->addColumn('status_name', function($user) {
            return $user->active ? 'Yes': 'No';
        })
        ->addColumn('job_html', function($user) {
            if ($user->user_jobrole == Roles::MULTISCHOOL) {
                return '<a href="'. route('admin.users.assign-school', ['id' => $user->id]) .'">'. $user->user_jobrole . '</a>';
            }

            return $user->user_jobrole;
        });

        $datatables->addColumn('actions', function ($user) {
            $edit_route = route('admin.users.edit', ['id' => $user->id]);
            $unlock_route = route('admin.users.unlock', ['id' => $user->id]);

            $btn = sprintf('<a href="%s" class="btn text-muted fs-sm" title="Edit">
                        <i class="fa fa-fw fas fa-edit mr-1"></i> Edit</a>', $edit_route);

            $btn .= sprintf('<a href="%s" class="btn btn-unlock text-muted fs-sm" title="Unlock">
                        <i class="fa fa-fw fas fa-unlock mr-1"></i> Unlock</a>', $unlock_route);

            if (Auth::user()->id != $user->id) {
                $delete_route = route('admin.users.delete', ['id' => $user->id]);
                $btn .= sprintf('<a href="%s" class="btn btn-delete text-danger fs-sm" title="Delete">
                    <i class="fa fa-fw fas fa-trash mr-1"></i> Delete</a>', $delete_route);
            }
            return $btn;
        });

        if (!empty($keyword)) {
            $datatables->filter(function ($query) use ($keyword) {
                return $query->where(function ($sql) use ($keyword) {
                    $sql->orWhere("username", 'LIKE', "%$keyword%")
                    ->orWhere("user_fullname", 'LIKE', "%$keyword%");
                });
            });
        }

        return $datatables->rawColumns(['actions', 'job_html'])->make(true);
    }

    public function deleteUser($user_id)
    {
        return User::where('id', $user_id)->delete();
    }
}
