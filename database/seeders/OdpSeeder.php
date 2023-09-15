<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OdpSeeder extends Seeder
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
                'kode' => 'ODP-1',
                'latitude' => '-6.764576',
                'longitude' => '108.4797201',
                'address' => 'Sumber',
                'power' => '-9',
                'port_max' => 16,
                'port_used' => 0,
                'keterangan' => 'ODP Fat',
                'jarak_pop' => '456 m',
            ],
            [
                'kode' => 'ODP-2',
                'latitude' => '-6.7212417',
                'longitude' => '108.4502715',
                'address' => 'Plumbon',
                'power' => '-7',
                'port_max' => 16,
                'port_used' => 0,
                'keterangan' => 'ODP Slim',
                'jarak_pop' => '456 m',
            ],
            [
                'kode' => 'ODP-3',
                'latitude' => '-6.714761831540589',
                'longitude' => '108.55066472585287',
                'address' => 'Cirkot',
                'power' => '-4',
                'port_max' => 16,
                'port_used' => 0,
                'keterangan' => 'ODP Paling Deket',
                'jarak_pop' => '456 m',
            ],
        ];

        DB::table('odps')->insert($data);
    }
}
