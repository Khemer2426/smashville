<?php

namespace App\Components\Services\Impl;

use App\Components\Services\ICommandService;
use App\Components\Services\IEmailNotificationService;
use App\Components\Services\IEmailService;
use App\Exceptions\ProcessException;
use Illuminate\Support\Facades\DB;

class CommandService implements ICommandService {

    public $_emailService;
    public $_emailNotificationService;
    
    public function __construct(
        IEmailService $emailService,
        IEmailNotificationService $emailNotificationService
    )
    {
		$this->_emailService = $emailService;
		$this->_emailNotificationService = $emailNotificationService;
    }

    public function sendEmailNotifications() 
    {
      	$email_notifications = $this->_emailNotificationService->getUnSentEmailNotification();

      	foreach ($email_notifications as $email_notification) {
			try {

			DB::transaction(function() use ($email_notification) {
				$recipients = explode(', ', $email_notification->recipient);

				$attachments = [];
				$email_attachments = $email_notification->attachments;
				foreach ($email_attachments as $attachment) {
					$attachments[] = [
						'file_name' => $attachment->file_name,
						'content' => base64_decode($attachment->content)
					];
				}

				$reply_to = $email_notification->reply_to ?? null;
			
				$this->_emailService->send(
					$email_notification->subject,
					$email_notification->body,
					$recipients,
					$attachments,
					$reply_to
				);

				$this->_emailNotificationService->setEmailAsSent($email_notification->id);
			});

			} catch (ProcessException $pex) {
				// Don't throw error so it won't stop sending email to other recipients
			}
      	}
    }
}
