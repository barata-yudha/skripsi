<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OntSeeder extends Seeder
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
                'merk_ont' => 'ZTE',
                'type_ont' => 'F609',
                'versi_ont' => 'V9',
            ],
            [
                'merk_ont' => 'ZTE',
                'type_ont' => 'F660',
                'versi_ont' => 'V8',
            ],
        ];

        DB::table('onts')->insert($data);
    }
}
