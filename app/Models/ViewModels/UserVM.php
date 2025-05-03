<?php 

namespace App\Models\ViewModels;

class UserVM
{
    public $id;
    public $username;
    public $fullname;
    public $roles;
    public $school;
    public $active;
    public $schools;

    public function __construct(
        $id, 
        $username,
        $fullname,
        $roles,
        $school,
        $active,
        $schools
    )
    {
        $this->id = $id;
        $this->username = $username;
        $this->fullname = $fullname;
        $this->roles = $roles;
        $this->school = $school;
        $this->active = $active;
        $this->schools = $schools;
    }
}