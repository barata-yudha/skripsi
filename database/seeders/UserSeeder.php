<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
                'name'  => 'Admin 1',
                'email' => 'admin1@gmail.com',
                'username' => 'admin1',
                'password' => Hash::make('123456'),
                'role' => 'admin'
            ],
            [
                'name'  => 'Admin 2',
                'email' => 'admin2@gmail.com',
                'username' => 'admin2',
                'password' => Hash::make('123456'),
                'role' => 'admin'
            ],
            [
                'name'  => 'Teknisi Jordan',
                'email' => 'teknisi1@gmail.com',
                'username' => 'teknisi1',
                'password' => Hash::make('123456'),
                'role' => 'teknisi'
            ],
            [
                'name'  => 'Teknisi Budi',
                'email' => 'teknisi2@gmail.com',
                'username' => 'teknisi2',
                'password' => Hash::make('123456'),
                'role' => 'teknisi'
            ],
            [
                'name'  => 'Owner',
                'email' => 'owner@gmail.com',
                'username' => 'owner',
                'password' => Hash::make('123456'),
                'role' => 'owner'
            ],
        ];

        DB::table('users')->insert($data);
    }
}
