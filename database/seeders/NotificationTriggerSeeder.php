<?php

namespace Database\Seeders;

use App\Constants\Components\NotificationTriggers;
use App\Models\Entities\NotificationTrigger;
use Illuminate\Database\Seeder;

class NotificationTriggerSeeder extends Seeder
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
                'name' => NotificationTriggers::ON_USER_REGISTRATION,
                'value' => NotificationTriggers::ON_USER_REGISTRATION_VALUE,
            ],
            [
                'name' => NotificationTriggers::ON_RESET_PASSWORD,
                'value' => NotificationTriggers::ON_RESET_PASSWORD_VALUE,
            ],
            [
                'name' => NotificationTriggers::ON_SENDING_TO_AM,
                'value' => NotificationTriggers::ON_SENDING_TO_AM_VALUE,
            ],
        ];

        foreach ($data as $item) {
            $table = new NotificationTrigger;
            $row = $table->where('name', $item['name'])->first();
            if (empty($row)) {
                $table->create($item);
                echo sprintf("Notification Trigger - %s has been added \n", $item['name']);
            }
        }
    }
}
