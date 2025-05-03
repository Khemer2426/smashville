<?php

namespace App\Components\Passive\Validators;

use Illuminate\Support\Facades\Validator;

class UserValidator
{
    public static function validateCreateUser($data)
    {
        $rules = [
            'username' => 'required|unique:tb_user|max:100',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
            'password_confirmation' => 'required|min:8',
            'full_name' => 'required|string|max:100',
            'role' => 'required|string|max:100',
            'active' => 'required'
        ];

        $messages = [];

        return Validator::make($data, $rules, $messages);
    }

    public static function validateUserId($data)
    {
        $rules = [
            "user_id" => "required|integer",
        ];

        $messages = [];

        return Validator::make($data, $rules, $messages);
    }

    public static function validateUpdateUser($data)
    {
        $rules = [
            'user_id' => 'required|integer',
            'password' => 'nullable|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
            'password_confirmation' => 'required_with:password',
            'full_name' => 'required|string|max:100',
            'role' => 'required|string|max:100',
            'active' => 'required'
        ];

        $messages = [];

        return Validator::make($data, $rules, $messages);
    }

    public static function validateChangePassword($data)
    {
        $rules = [
            "current_password" => "required|string|min:8",
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
            'password_confirmation' => 'required|min:8',
        ];

        $messages = [
            'password.regex' => 'The password must be at least 8 characters long, and should contain at least 1 uppercase, 1 lowercase, 1 numeric and 1 special character.',
        ];

        return Validator::make($data, $rules, $messages);
    }

    public static function validateDeleteAssignSchool($data)
    {
        $rules = [
            'user_id' => 'required|integer',
            'school_id' => 'required|integer',
        ];

        $messages = [];

        return Validator::make($data, $rules, $messages);
    }

    public static function validateUserIdAndSchoolId($data)
    {
        $rules = [
            'user_id' => 'required|integer',
            'school_id' => 'required|integer',
        ];

        $messages = [];

        return Validator::make($data, $rules, $messages);
    }

    

    public static function validateTFA($data)
    {
        $rules = [
            'tfa_password' => 'required|string|min:8|confirmed',
            'tfa_password_confirmation' => 'required|min:8'
        ];

        if (!empty($data['verification_code'])) {
            $rules['verification_code'] = 'required|min:6|max:6';
        }

        $messages = [
            'tfa_password.required' => 'The password field is required.',
            'tfa_password_confirmation.required' => 'The password confirmation field is required.',
        ];

        return Validator::make($data, $rules, $messages);
    }

    public static function validateTFACode($data)
    {
        $rules['code'] = 'required|min:6|max:6';

        $messages = [];

        return Validator::make($data, $rules, $messages);
    }
}
