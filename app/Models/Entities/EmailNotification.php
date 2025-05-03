<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class EmailNotification extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email_template_id', 'subject', 'body', 'recipient', 'reply_to', 'sent', 'date_sent',
    ];

    public function email_template()
    {
        return $this->belongsTo('App\Models\Entities\EmailTemplate', 'email_template_id', 'id');
    }

    public function attachments()
    {
        return $this->hasMany('App\Models\Entities\EmailAttachment', 'email_notification_id', 'id');
    }
}