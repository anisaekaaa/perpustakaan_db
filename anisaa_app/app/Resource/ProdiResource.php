<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProdiResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama_prodi' => $this->nama_prodi,
            'kode_prodi' => $this->kode_prodi,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}