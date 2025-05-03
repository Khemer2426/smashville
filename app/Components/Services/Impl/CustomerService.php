<?php

namespace App\Components\Services\Impl;

use App\Constants\Http\StatusCodes;
use App\Exceptions\ProcessException;

use Illuminate\Support\Facades\Session;
use App\Components\Services\ICustomerService;
use App\Components\Repositories\ICustomerRepository;

use App\Constants\Exception\ProcessExceptionMessage;
use App\Components\Services\IRolesPermissionsService;

class CustomerService implements ICustomerService
{
	private $_userRepository;

    public function __construct(
        ICustomerRepository $userRepository,
    )
    {
        $this->_userRepository = $userRepository;
    }

}