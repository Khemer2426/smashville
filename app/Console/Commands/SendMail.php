<?php

namespace App\Console\Commands;

use App\Components\Services\ICommandService;
use Illuminate\Console\Command;

class SendMail extends Command
{
    public $_commandService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Email sending';
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        //ICommandService $commandService
    )
    {
        parent::__construct();
        //$this->_commandService = $commandService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //$this->_commandService->sendEmailNotifications();
    }
}
