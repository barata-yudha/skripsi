<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class OdpCollection extends JsonResource
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
            'kode' => $this->kode,
            'alamat' => $this->address,
            'keterangan' => $this->keterangan,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'power' => $this->power,
            'port' => $this->port_used . '/' . $this->port_max,
            'jarak_pop' => $this->jarak_pop_sync,
            'marker_icon' => $this->icon == null ? asset('img/default.png') : url(Storage::url($this->icon)),
            'doc' => $this->doc == null ? asset('img/default.png') : url(Storage::url($this->doc)),
        ];
    }
}
