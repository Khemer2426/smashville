<?php 

namespace App\Components\Repositories\Impl;

use App\Components\Repositories\IEmailAttachmentRepository;
use App\Models\Entities\EmailAttachment;

class EmailAttachmentRepository implements IEmailAttachmentRepository
{
    public function createEmailAttachment($email_notification_id, $file_name, $content)
    {
        return EmailAttachment::create([
            'email_notification_id' => $email_notification_id,
            'file_name' => $file_name,
            'content' => $content
        ]);
    }
}