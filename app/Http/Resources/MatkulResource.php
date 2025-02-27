<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MatkulResource extends JsonResource
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
            'matkul' => $this->matkul,
            'jurusan' => $this->jurusan->jurusan ?? 'Tidak Ada',
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
