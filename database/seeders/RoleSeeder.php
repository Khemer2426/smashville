<?php

namespace Database\Seeders;

use App\Constants\Components\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => Roles::ADMIN,
                'guard_name' => 'web'
            ],
            [
                'name' => Roles::STAFF,
                'guard_name' => 'web'
            ],
            [
                'name' => Roles::CUSTOMER,
                'guard_name' => 'web'
            ],
        ];

        foreach ($data as $item) {
            $table = new Role();
            $row = $table->where('name', $item['name'])->first();
            if (empty($row)) {
                $table->create($item);
                echo sprintf("Role - %s has been added \n", $item['name']);
            } else {
                $row->update($item);
            }
        }
    }
}
