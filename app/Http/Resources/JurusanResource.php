<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JurusanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'jurusan' => $this->jurusan,
            'fakultas' => $this->fakultas->nama_fakultas ?? 'Tidak Ada',
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
