<?php 

namespace App\Components\Repositories;

interface IEmailAttachmentRepository
{
    public function createEmailAttachment($email_notification_id, $file_name, $content);
}