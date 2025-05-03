<?php 

namespace App\Constants\Components;

use PhpParser\Node\Stmt\Const_;

class NotificationTriggers 
{
    public const ON_USER_REGISTRATION = 'ON_USER_REGISTRATION';
    public const ON_USER_REGISTRATION_VALUE = 1;

    public const ON_RESET_PASSWORD = 'ON_RESET_PASSWORD';
    public const ON_RESET_PASSWORD_VALUE = 2;

    public const ON_SENDING_TO_AM = 'ON_SENDING_TO_AM';
    public const ON_SENDING_TO_AM_VALUE = 3;
}