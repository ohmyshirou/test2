<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['name' => 'warek'],
            ['name' => 'dekan', 'faculty' => 'FTD'],
            ['name' => 'dekan', 'faculty' => 'FHB'],
            ['name' => 'bkal'],
            ['name' => 'bpm'],
            ['name' => 'bem'],
            ['name' => 'hima', 'faculty' => 'FTD'],
            ['name' => 'hima', 'faculty' => 'FHB'],
            ['name' => 'ukm'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
