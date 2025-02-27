<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MahasiswaMatkulResource extends JsonResource
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
            'mahasiswa' => $this->mahasiswa->nama ?? 'Tidak Ada',
            'matkul' => $this->matkul->matkul ?? 'Tidak Ada',
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
