<?php

namespace Database\Seeders;

use App\Constants\Components\NotificationTriggers;
use App\Models\Entities\EmailTemplate;
use App\Models\Entities\NotificationTrigger;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'notification_trigger_id' => NotificationTrigger::where("name", NotificationTriggers::ON_USER_REGISTRATION)->first()->id,
                'body' => '<p>Please click on the <a href="{{user_activation_link}}">link</a> to activate your account.</p>',
                'subject' => 'Activation for User {{username}}'
            ], 
            [
                'notification_trigger_id' => NotificationTrigger::where("name", NotificationTriggers::ON_RESET_PASSWORD)->first()->id,
                'body' => '<p>Please click on the <a href="{{change_password_link}}">link</a> to change your password.</p>',
                'subject' => 'Reset Password for User {{username}}'
            ], 
            [
                'notification_trigger_id' => NotificationTrigger::where("name", NotificationTriggers::ON_SENDING_TO_AM)->first()->id,
                'body' => '<p>A message from the customer: {{sender_name}}<br>Company: {{company}}</p>
                Message: <br>
                <div class="blockquote">{{message}}</div>
                <p>You can reply this message.</p>',
                'subject' => '{{subject}}'
            ]
        ];

        foreach ($data as $item)
        {
            $table = new EmailTemplate;
            $row = $table->where('notification_trigger_id', $item['notification_trigger_id'])->first();
            if (empty($row)) {
                $table->create($item);
                echo sprintf("Email Template - %s has been added \n", $item['subject']);
            } else {
                $row->update($item);
            }
        }
    }
}
