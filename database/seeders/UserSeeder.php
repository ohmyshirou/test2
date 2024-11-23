<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
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
        User::create([
            'username' => 'BKAL',
            'password' => Hash::make('123'), // Pastikan untuk menghash password
            'email' => 'superadmin@bkal.com',
            'role' => 'BKAL',
        ]);

        User::create([
            'username' => 'BPM',
            'password' => Hash::make('123'),
            'email' => 'bpm@bkal.com',
            'role' => 'BPM',
        ]);

        User::create([
            'username' => 'HIMA-SIF',
            'password' => Hash::make('123'),
            'email' => 'hima.sif@bkal.com',
            'role' => 'Organisasi',
        ]);

        User::create([
            'username' => 'HIMA-DKV',
            'password' => Hash::make('123'),
            'email' => 'hima.dkv@bkal.com',
            'role' => 'Organisasi',
        ]);

        User::create([
            'username' => 'HIMA-TSP',
            'password' => Hash::make('123'),
            'email' => 'hima.tsp@bkal.com',
            'role' => 'Organisasi',
        ]);

        User::create([
            'username' => 'HIMA-ARS',
            'password' => Hash::make('123'),
            'email' => 'hima.ars@bkal.com',
            'role' => 'Organisasi',
        ]);

        User::create([
            'username' => 'HIMA-DP',
            'password' => Hash::make('123'),
            'email' => 'hima.dp@bkal.com',
            'role' => 'Organisasi',
        ]);

        User::create([
            'username' => 'HIMA-TIF',
            'password' => Hash::make('123'),
            'email' => 'hima.tif@bkal.com',
            'role' => 'Organisasi',
        ]);

        User::create([
            'username' => 'HIMA-AKT',
            'password' => Hash::make('123'),
            'email' => 'hima.akt@bkal.com',
            'role' => 'Organisasi',
        ]);

        User::create([
            'username' => 'HIMA-MNJ',
            'password' => Hash::make('123'),
            'email' => 'hima.mnj@bkal.com',
            'role' => 'Organisasi',
        ]);

        User::create([
            'username' => 'HIMA-KOM',
            'password' => Hash::make('123'),
            'email' => 'hima.kom@bkal.com',
            'role' => 'Organisasi',
        ]);

        User::create([
            'username' => 'HIMA-PSI',
            'password' => Hash::make('123'),
            'email' => 'hima.psi@bkal.com',
            'role' => 'Organisasi',
        ]);
    }
}