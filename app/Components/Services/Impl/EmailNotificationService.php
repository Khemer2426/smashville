<?php

namespace App\Components\Services\Impl;

use App\Components\Repositories\IEmailAttachmentRepository;
use App\Components\Repositories\IEmailNotificationRepository;
use App\Components\Repositories\IEmailTemplateRepository;
use App\Components\Repositories\INotificationTriggerRepository;
use App\Components\Services\IEmailNotificationService;
use App\Constants\Exception\ProcessExceptionMessage;
use App\Constants\Http\StatusCodes;
use App\Exceptions\ProcessException;

class EmailNotificationService implements IEmailNotificationService
{
    private $_emailTemplateRepository;
    private $_notificationTriggerRepository;
    private $_emailNotificationRepository;
    private $_emailAttachmentRepository;

    public function __construct(
        IEmailTemplateRepository $emailTemplateRepository,
        INotificationTriggerRepository $notificationTriggerRepository,
        IEmailNotificationRepository $emailNotificationRepository,
        IEmailAttachmentRepository $emailAttachmentRepository
    ) {
        $this->_emailTemplateRepository = $emailTemplateRepository;
        $this->_notificationTriggerRepository = $notificationTriggerRepository;
        $this->_emailNotificationRepository = $emailNotificationRepository;
        $this->_emailAttachmentRepository = $emailAttachmentRepository;
    }

    public function createEmailNotification(
        $properties,
        $trigger_value,
        $recipient,
        $attachments = [],
        $reply_to = null
    )
    {
        $notification_trigger = $this->_notificationTriggerRepository->getByValue($trigger_value);

        if (empty($notification_trigger)) {
            throw new ProcessException(
                ProcessExceptionMessage::NOTIFICATION_TRIGGER_DOES_NOT_EXIST,
                StatusCodes::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        $email_template = $this->_emailTemplateRepository->getByNotificationTriggerId($notification_trigger->id);

        if (empty($email_template)) {
            throw new ProcessException(
                ProcessExceptionMessage::EMAIL_TEMPLATE_DOES_NOT_EXIST,
                StatusCodes::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        $interpolated_subject = $this->interpolate($properties, $email_template->subject);
        $interpolated_body = $this->interpolate($properties, $email_template->body);
        $recipient = join(', ', $recipient);

        $email_notification = $this->_emailNotificationRepository->createEmailNotification(
            $email_template->id,
            $interpolated_subject,
            $interpolated_body,
            $recipient,
            $reply_to
        );

        if (!empty($attachments)) {
            foreach ($attachments as $attachment) {
                $this->_emailAttachmentRepository->createEmailAttachment(
                    $email_notification->id,
                    $attachment['file_name'],
                    $attachment['content']
                );
            }
        }
    }

    private function interpolate($properties, $text)
    {
        foreach($properties as $key => $val) {
            $pattern = '/{{'. $key .'}}/i';
            $text = preg_replace($pattern, $val, $text);
        }

        return $text;
    }

    public function getUnSentEmailNotification($limit = 100)
    {
        return $this->_emailNotificationRepository->getUnSentEmailNotification($limit);
    }

    public function getEmailNotification($id)
    {
        $email_notification = $this->_emailNotificationRepository->getEmailNotification($id);

        if (empty($email_notification)) {
            throw new ProcessException(
                ProcessExceptionMessage::EMAIL_NOTIFICATION_DOES_NOT_EXIST,
                StatusCodes::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return $email_notification;
    }

    public function setEmailAsSent($id)
    {
       $email_notification = $this->getEmailNotification($id);

       return $this->_emailNotificationRepository->setEmailAsSent($email_notification->id);
    }
}
