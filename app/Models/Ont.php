<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ont extends Model
{
    use HasFactory;

    public function timeslots()
    {
        return $this->hasMany(Timeslot::class);
    }

    public function getNamaLengkapAttribute()
    {
        return $this->merk_ont . ' ' . $this->type_ont . ' ' . $this->versi_ont;
    }

    protected $appends = [
        'nama_lengkap'
    ];

}
