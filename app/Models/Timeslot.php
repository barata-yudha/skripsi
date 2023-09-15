<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeslot extends Model
{
    use HasFactory;

    public function ont()
    {
        return $this->belongsTo(Ont::class)->withDefault([
            'merk_ont' => '-',
            'type_ont' => '-',
            'versi_ont' => '-',
        ]);
    }

    public function odp()
    {
        return $this->belongsTo(Odp::class)->withDefault([
            'kode' => '-',
            'power' => '-',
            'port_max' => '-',
            'port_used' => '-',
            'keterangan' => '-',
            'nama' => '-',
            'address' => '-',
        ]);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class)->withDefault([
            'nama' => '-',
            'alamat' => '-',
        ]);
    }

    public function pj()
    {
        return $this->belongsTo(User::class, 'taken_by', 'id')->withDefault([
            'name' => '-',
        ]);
    }
}
