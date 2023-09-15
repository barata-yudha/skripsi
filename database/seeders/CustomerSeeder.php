<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
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
                'nama' => 'Ahmadin',
                'no_hp' => '089661030388',
                'alamat' => 'Bode Lor'
            ],
            [
                'nama' => 'Iyas',
                'no_hp' => '08171712343',
                'alamat' => 'Kuningan'
            ],
        ];

        DB::table('customers')->insert($data);
    }
}
