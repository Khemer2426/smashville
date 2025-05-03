<?php

namespace Database\Seeders;

use App\Constants\Components\Roles;
use App\Models\Entities\User;
use App\Models\Entities\Role;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
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
                'username' => 'genevev.manlangit@gmail.com',
                'password' => Hash::make('Admin1234!'),
                'active' => 1,
                'email_verified_at' => Carbon::now(),
            ],
            [
                'username' => 'smashville.admin@gmail.com',
                'password' => Hash::make('Admin1234!'),
                'active' => 1,
                'email_verified_at' => Carbon::now(),
            ],
        ];

        foreach ($data as $item) {
            $table = new User;
            $row = $table->where('username', $item['username'])->first();
            if (empty($row)) {
                $user = User::create($item);
                $user->assignRole('admin');

                echo sprintf("User - %s has been added \n", $item['username']);
            } else {
                $row->update($item);
            }
        }
    }
}
