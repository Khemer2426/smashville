<?php

namespace App\Components\Services;

interface IEmailNotificationService
{
    public function createEmailNotification(
        $properties, 
        $trigger_value, 
        $recipient, 
        $attachments = [], 
        $reply_to = null
    );

    public function getUnSentEmailNotification($limit = 100);

    public function getEmailNotification($id);

    public function setEmailAsSent($id);
}
