<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'recipient_type_id', 'notification_trigger_id', 'subject', 'body',
    ];

    public function notification_trigger()
    {
        return $this->belongsTo('App\Models\Entities\NotificationTrigger', 'notification_trigger_id', 'id');
    }

    public function recipient_type()
    {
        return $this->belongsTo('App\Models\Entities\RecipientType', 'recipient_type_id', 'id');
    }

    public function email_notifications()
    {
        return $this->hasMany('App\Models\Entities\EmailNotification', 'email_template_id', 'id');
    }
}