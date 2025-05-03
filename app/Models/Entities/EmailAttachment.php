<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class EmailAttachment extends Model
{
    protected $fillable = [
        'email_notification_id', 'file_name', 'content',
    ];

    public function email_notification()
    {
        return $this->belongsTo('App\Models\Entities\EmailNotification', 'email_notification_id', 'id');
    }
}
