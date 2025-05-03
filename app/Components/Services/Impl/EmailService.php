<?php

namespace App\Components\Services\Impl;

use App\Components\Services\IEmailService;
use App\Constants\Exception\ProcessExceptionMessage;
use App\Constants\Http\StatusCodes;
use App\Exceptions\ProcessException;
use App\Mail\MailTemplate;
use App\Mail\SendEmail;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailService implements IEmailService {

    public function send($subject, $body, $recipient, $attachments, $reply_to = null)
    {
        try {
            Mail::to($recipient)->send(new SendEmail($subject, $body, $attachments, $reply_to));
        } catch (Exception $e) {
            Log::error("Sending mail: ".$e->getMessage());

            throw new ProcessException(
                ProcessExceptionMessage::ERROR_IN_SENDING_EMAIL,
                StatusCodes::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
