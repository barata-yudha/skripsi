<?php

namespace App\Models;

use App\Helpers\MyHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Odp extends Model
{
    use HasFactory;

    public function timeslots()
    {
        return $this->hasMany(Timeslot::class);
    }

    public function getJarakPopSyncAttribute()
    {
        $koor1 = $this->latitude . ',' . $this->longitude;
        $koor2 = env('LAT_DEFAULT') . ',' . env('LONG_DEFAULT');

        if (MyHelper::validateLatLong($this->latitude, $this->longitude) == false) {
            return null;
        }
        return MyHelper::measuringDistance($koor1, $koor2);
    }

    protected $appends = [
        'jarak_pop_sync'
    ];
}
