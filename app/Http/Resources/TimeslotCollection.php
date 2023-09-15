<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TimeslotCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'customer_name' => $this->customer->nama,
            'customer_address' => $this->customer->alamat,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'odp' => $this->odp->kode,
            'ont' => $this->ont->nama_lengkap,
            'serial_number' => $this->serial_number,
            'cable_distance' => $this->cable_distance,
            'marker_icon' => asset('img/ticket.png'),
            'doc' => $this->doc == null ? asset('img/default.png') : url(Storage::url($this->doc)),
        ];
    }
}
