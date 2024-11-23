<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacultySeeder extends Seeder
{
    public function run()
    {
        DB::table('faculties')->insert([
            ['name' => 'FTD'],
            ['name' => 'FHB'],
        ]);
    }
    
}
