<?php

namespace App\Components\Passive\Validators;

use Illuminate\Support\Facades\Validator;

class AuthenticationValidator
{

    public static function validateLogin($data)
    {
        $rules = [
            "username" => "required|max:100|max:100",
            "password" => "required|min:8",
        ];

        $messages = [];

        return Validator::make($data, $rules, $messages);
    }

    public static function validateUsername($data)
    {
        $rules = [
            "username" => "required|max:100",
        ];

        $messages = [];

        return Validator::make($data, $rules, $messages);
    }

    public static function validateCode($data)
    {
        $rules = [
            "code" => "required|max:50",
        ];

        $messages = [];

        return Validator::make($data, $rules, $messages);
    }

    public static function validateCodeAndPassword($data)
    {
        $rules = [
            "code" => "required|max:50",
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
            'password_confirmation' => 'required|min:8',
        ];

        $messages = [
            'password.regex' => 'The password must be at least 8 characters long, and should contain at least 1 uppercase, 1 lowercase, 1 numeric and 1 special character.',
        ];

        return Validator::make($data, $rules, $messages);
    }

    public static function validateResetPassword($data)
    {
        $rules = [
            'code' => 'required|max:50',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
            'password_confirmation' => 'required|min:8',
        ];

        $messages = [
            'password.regex' => 'The password must be at least 8 characters long, and should contain at least 1 uppercase, 1 lowercase, 1 numeric and 1 special character.',
        ];

        return Validator::make($data, $rules, $messages);
    }
}


