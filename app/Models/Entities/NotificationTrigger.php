<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class NotificationTrigger extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'value',
    ];

    public function email_template()
    {
        return $this->hasOne('App\Models\Entities\EmailTemplate', 'notification_trigger_id', 'id');
    }
}